<?php

namespace app\controllers;

use app\models\Carts;
use app\models\CartsSearch;
use app\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Orders;
/**
 * CartsController implements the CRUD actions for Carts model.
 */
class CartsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Carts models for current user.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartsSearch();
        
        // Фильтруем по текущему пользователю
        $queryParams = $this->request->queryParams;
        if (Yii::$app->user->isGuest) {
            $queryParams['CartsSearch']['user_id'] = 0; // Пустой результат для гостей
        } else {
            $queryParams['CartsSearch']['user_id'] = Yii::$app->user->identity->id;
        }
        
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carts model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carts model (добавление товара в корзину).
     * @param int $product_id ID товара
     * @return \yii\web\Response
     */
    public function actionAdd($product_id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', 'Для добавления в корзину необходимо авторизоваться.');
            return $this->redirect(['site/login']);
        }
        
        $product = \app\models\Product::findOne($product_id);
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден.');
        }
        
        $userId = Yii::$app->user->identity->id;
        
        // Проверяем, есть ли уже этот товар в корзине пользователя
        $existingCartItem = Carts::find()
            ->where(['product_id' => $product_id, 'user_id' => $userId])
            ->one();
        
        if ($existingCartItem) {
            Yii::$app->session->setFlash('info', 'Этот товар уже есть в вашей корзине.');
            return $this->redirect(Yii::$app->request->referrer ?: ['site/index']);
        }
        
        // Создаем новую запись в корзине
        $cart = new Carts();
        $cart->product_id = $product_id;
        $cart->user_id = $userId;
        $cart->cost = $product->cost;
        
        if ($cart->save()) {
            Yii::$app->session->setFlash('success', 'Товар "' . $product->name . '" успешно добавлен в корзину!');
        } else {
            Yii::$app->session->setFlash('error', 'Произошла ошибка при добавлении товара в корзину.');
        }
        
        return $this->redirect(Yii::$app->request->referrer ?: ['site/index']);
    }

    /**
     * Updates an existing Carts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Carts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Проверяем, что пользователь удаляет свою запись
        if (!Yii::$app->user->isGuest && $model->user_id == Yii::$app->user->identity->id) {
            
            // ПРОВЕРЯЕМ ЕСТЬ ЛИ ЗАКАЗ ДЛЯ ЭТОЙ КОРЗИНЫ
            $orderExists = \app\models\Orders::find()->where(['carts_id' => $model->id])->exists();
                
            if ($orderExists) {
                Yii::$app->session->setFlash('error', 
                    'Нельзя удалить товар, по которому оформлен заказ. ' .
                    'Сначала отмените заказ в разделе "Мои заказы".'
                );
                // ИЗМЕНЯЕМ РЕДИРЕКТ НА orders/index
                return $this->redirect(['orders/index']);
            }
            
            $model->delete();
            Yii::$app->session->setFlash('success', 'Товар удален из корзины.');
        } else {
            Yii::$app->session->setFlash('error', 'У вас нет прав для удаления этого товара.');
        }
    
        // ИЛИ ТАК: редирект туда, откуда пришел пользователь
        return $this->redirect(Yii::$app->request->referrer ?: ['carts/index']);
    }

    /**
     * Очищает всю корзину текущего пользователя.
     * @return \yii\web\Response
     */
    public function actionClear()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        
        $userId = Yii::$app->user->identity->id;
        $deletedCount = Carts::deleteAll(['user_id' => $userId]);
        
        Yii::$app->session->setFlash('success', "Корзина очищена. Удалено товаров: {$deletedCount}");
        return $this->redirect(['site/cart']);
    }

    /**
     * Получает количество товаров в корзине для текущего пользователя.
     * @return int
     */
    public function actionCount()
    {
        if (Yii::$app->user->isGuest) {
            return 0;
        }
        
        $count = Carts::find()
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->count();
            
        return $count;
    }

    /**
     * Находит модель Carts по первичному ключу.
     * Если модель не найдена, выбрасывается исключение 404.
     * @param int $id ID
     * @return Carts загруженная модель
     * @throws NotFoundHttpException если модель не найдена
     */
    protected function findModel($id)
    {
        if (($model = Carts::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}