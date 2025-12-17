<?php

namespace app\controllers;

use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Carts;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Только авторизованные
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'cancel' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models for current user.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        
        // Фильтруем только заказы текущего пользователя
        $queryParams = $this->request->queryParams;
        $queryParams['OrdersSearch']['user_id'] = Yii::$app->user->identity->id;
        
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        // Проверяем, что пользователь смотрит свой заказ
        if ($model->cart->user_id != Yii::$app->user->identity->id) {
            throw new NotFoundHttpException('У вас нет доступа к этому заказу.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Orders model (оформление заказа из корзины).
     * @param int $cart_id ID товара в корзине
     * @return string|\yii\web\Response
     */
    /**
 * Creates a new Orders model (оформление заказа).
 * @param int $cart_id ID товара в корзине (опционально)
 * @return string|\yii\web\Response
 */
public function actionCreate($cart_id = null)
{
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }
    
    $userId = Yii::$app->user->identity->id;
    
    // Если cart_id не передан, берем первый товар из корзины пользователя
    if (!$cart_id) {
        $cart = Carts::find()
            ->where(['user_id' => $userId])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        
        if (!$cart) {
            Yii::$app->session->setFlash('error', 'Ваша корзина пуста.');
            return $this->redirect(['carts/index']);
        }
        
        $cart_id = $cart->id;
    }
    
    // Находим товар в корзине
    $cart = Carts::findOne(['id' => $cart_id, 'user_id' => $userId]);
    
    if (!$cart) {
        throw new NotFoundHttpException('Товар в корзине не найден.');
    }
    
    // Проверяем, не оформлен ли уже заказ
    $existingOrder = Orders::find()->where(['carts_id' => $cart_id])->one();
    if ($existingOrder) {
        Yii::$app->session->setFlash('error', 'По этому товару уже оформлен заказ.');
        return $this->redirect(['carts/index']);
    }
    
    $model = new Orders();
    $model->carts_id = $cart_id;
    $model->date = date('Y-m-d H:i:s');
    $model->status = 'Ожидает оплаты'; // Статус по умолчанию
    
    if ($this->request->isPost) {
        if ($model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Заказ успешно оформлен!');
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }
    
    return $this->render('create', [
        'model' => $model,
        'cart' => $cart,
    ]);
}
    /**
     * Отмена заказа (удаление).
     * @param int $id ID заказа
     * @return \yii\web\Response
     * @throws NotFoundHttpException если модель не найдена
     */
    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        
        // Проверяем, что пользователь отменяет свой заказ
        if ($model->cart->user_id != Yii::$app->user->identity->id) {
            throw new NotFoundHttpException('У вас нет прав для отмены этого заказа.');
        }
        
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Заказ успешно отменен.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось отменить заказ.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // Проверяем, что пользователь обновляет свой заказ
        if ($model->cart->user_id != Yii::$app->user->identity->id) {
            throw new NotFoundHttpException('У вас нет прав для изменения этого заказа.');
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Заказ успешно обновлен.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Проверяем, что пользователь удаляет свой заказ
        if ($model->cart->user_id != Yii::$app->user->identity->id) {
            throw new NotFoundHttpException('У вас нет прав для удаления этого заказа.');
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Заказ успешно удален.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}