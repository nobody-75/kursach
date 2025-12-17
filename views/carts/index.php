<?php

use app\models\Carts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;

/** @var yii\web\View $this */
/** @var app\models\CartsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;

// Фильтруем только товары текущего пользователя
if (!Yii::$app->user->isGuest) {
    $dataProvider->query->andWhere(['user_id' => Yii::$app->user->identity->id]);
}

// Подсчет общей суммы
$totalSum = 0;
$cartItems = $dataProvider->getModels();
foreach ($cartItems as $item) {
    if (is_numeric($item->cost)) {
        $totalSum += (float) $item->cost;
    }
}
?>
<div class="carts-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> 
            Для просмотра корзины необходимо 
            <a href="<?= Url::to(['site/login']) ?>" class="alert-link">авторизоваться</a>.
        </div>
    <?php elseif (empty($cartItems)): ?>
        <div class="alert alert-info">
            <div class="text-center py-4">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h4>Ваша корзина пуста</h4>
                <p class="text-muted">Добавьте товары, чтобы они отобразились здесь</p>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-1"></i> Перейти к товарам
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Информация о корзине -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Товаров в корзине: 
                            <span class="badge bg-primary fs-6"><?= count($cartItems) ?></span>
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h4 class="text-success mb-0">
                            Общая сумма: <strong><?= number_format($totalSum, 2, '.', ' ') ?> ₽</strong>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Таблица товаров -->
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => SerialColumn::class,
                        'header' => '№',
                    ],

                    [
                        'attribute' => 'product_id',
                        'label' => 'Товар',
                        'value' => function($model) {
                            return $model->product ? Html::encode($model->product->name) : '<span class="text-danger">Товар удален</span>';
                        },
                        'format' => 'raw',
                    ],
                    
                    [
                        'label' => 'Категория',
                        'value' => function($model) {
                            return $model->product ? Html::encode($model->product->kategoty) : '-';
                        },
                        'format' => 'raw',
                    ],
                    
                    [
                        'attribute' => 'cost',
                        'label' => 'Цена',
                        'value' => function($model) {
                            return number_format($model->cost, 2, '.', ' ') . ' ₽';
                        },
                        'format' => 'raw',
                    ],
                    
                    [
                        'attribute' => 'user_id',
                        'label' => 'Пользователь',
                        'value' => function($model) {
                            return $model->user ? Html::encode($model->user->fio) : 'Гость';
                        },
                        'format' => 'raw',
                        'visible' => Yii::$app->user->identity->user_role === '1', // Только для админов
                    ],

                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {delete}',
                        'buttons' => [
                            'view' => function($url, $model, $key) {
                                if ($model->product) {
                                    return Html::a(
                                        '<i class="fas fa-eye"></i>',
                                        ['product/view', 'id' => $model->product_id],
                                        [
                                            'class' => 'btn btn-sm btn-outline-primary',
                                            'title' => 'Просмотр товара',
                                            'data-pjax' => '0'
                                        ]
                                    );
                                }
                                return '';
                            },
                            'delete' => function($url, $model, $key) {
                                return Html::a(
                                    '<i class="fas fa-trash"></i>',
                                    ['delete', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'title' => 'Удалить из корзины',
                                        'data-confirm' => 'Удалить этот товар из корзины?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0'
                                    ]
                                );
                            },
                        ],
                        'urlCreator' => function ($action, Carts $model, $key, $index, $column) {
                            if ($action === 'view' && $model->product) {
                                return Url::to(['product/view', 'id' => $model->product_id]);
                            }
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'visibleButtons' => [
                            'delete' => function($model, $key, $index) {
                                // Пользователь может удалять только свои товары
                                return Yii::$app->user->identity->id == $model->user_id;
                            }
                        ]
                    ],
                ],
                'tableOptions' => ['class' => 'table table-hover table-bordered'],
                'pager' => [
                    'options' => ['class' => 'pagination justify-content-center mt-4'],
                    'linkOptions' => ['class' => 'page-link'],
                    'pageCssClass' => 'page-item',
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'disabledPageCssClass' => 'page-item disabled',
                    'activePageCssClass' => 'page-item active',
                ],
            ]); ?>
        </div>

       <!-- В разделе Кнопки действий: -->
<div class="col-md-6 text-md-end">
    <?php if (!empty($cartItems)): ?>
        <?php 
        // Берем первый товар из корзины
        $firstCartItem = reset($cartItems);
        ?>
        <a href="<?= Url::to(['orders/create', 'cart_id' => $firstCartItem->id]) ?>" 
           class="btn btn-success btn-lg">
            <i class="fas fa-credit-card me-1"></i> Оформить заказ
        </a>
    <?php endif; ?>
</div>