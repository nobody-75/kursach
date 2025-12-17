<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Product;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    // Получаем уникальные категории из поля kategoty
    $categories = Product::find()
        ->select('kategoty')
        ->distinct()
        ->where(['not', ['kategoty' => null]])
        ->orderBy('kategoty')
        ->all();
    
    return $this->render('index', [
        'categories' => $categories
    ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


        /**
     * Displays about page.
     *
     * @return string
     */
    public function actionReg()
    {
        $model = new User();
        
        // ОБРАБОТКА POST-ЗАПРОСА (это главное!)
        if ($model->load(Yii::$app->request->post())) {
            
            // Дополнительная обработка если нужно
            // Например, если поле password должно хешироваться:
            // $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            
            if ($model->save()) {
                Yii::$app->session->setFlash();
                return $this->redirect(['site/index']); // или куда вам нужно
            } else {
                Yii::$app->session->setFlash('error', 
                    'Ошибка регистрации: ' . 
                    implode(', ', array_map(function($errors) {
                        return implode(', ', $errors);
                    }, $model->errors))
                );
            }
        }
        
        return $this->render('reg', [
            'model' => $model,
        ]);
    }

        /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAdmin()
    {
        return $this->render('admin');
    }

      /**
     * Displays about page.
     *
     * @return string
     */
    public function actionCart()
    {
        return $this->render('cart');
    }

      /**
     * Displays about page.
     *
     * @return string
     */
    public function actionOrder()
    {
        return $this->render('order');
    }

    public function actionPhone()
    {
        return $this->render('phone');
    }

     public function actionComputer()
    {
        return $this->render('computer');
    }
}
