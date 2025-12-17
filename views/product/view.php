<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Product $model */


\yii\web\YiiAsset::register($this);
?>

<div class="container mt-4">
    <!-- Хлебные крошки -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['site/index']) ?>" class="text-decoration-none text-warning">
                    <i class="bi bi-house-door-fill me-1"></i>Главная
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['product/all']) ?>" class="text-decoration-none text-warning">
                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>Все товары
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                <i class="bi bi-cup-straw text-warning me-1"></i><?= Html::encode($model->name) ?>
            </li>
        </ol>
    </nav>

    <!-- Основной контент -->
    <div class="row g-4">
        <!-- Изображение товара -->
        <div class="col-lg-6">
            <div class="card border-warning shadow">
                <div class="card-header bg-dark">
                    <h5 class="text-warning mb-0">
                        <i class="bi bi-image-fill me-2"></i>Внешний вид
                    </h5>
                </div>
                <div class="card-body bg-light text-center p-4">
                    <?php if (!empty($model->photo) && $model->photo !== 'а'): ?>
                        <img src="<?= Html::encode($model->photo) ?>" 
                             class="img-fluid rounded shadow" 
                             alt="<?= Html::encode($model->name) ?>" 
                             style="max-height: 400px; width: auto;">
                    <?php else: ?>
                        <div class="bg-dark bg-opacity-10 d-flex align-items-center justify-content-center rounded" 
                             style="height: 300px;">
                            <div>
                                <i class="bi bi-image display-1 text-muted"></i>
                                <p class="text-dark mt-3">Изображение отсутствует</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Информация о товаре -->
        <div class="col-lg-6">
            <div class="card border-warning shadow h-100">
                <div class="card-header bg-dark">
                    <h1 class="text-warning h4 mb-0">
                        <i class="bi bi-cup-hot-fill me-2"></i><?= Html::encode($model->name) ?>
                    </h1>
                </div>
                <div class="card-body bg-light d-flex flex-column">
                    <!-- Цена -->
                    <div class="alert alert-dark text-center mb-4">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="bi bi-currency-dollar text-warning fs-4 me-3"></i>
                            <div>
                                <div class="text-light small">ЦЕНА</div>
                                <div class="fw-bold text-warning fs-2"><?= Html::encode($model->cost) ?> ₽</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Описание -->
                    <div class="mb-4">
                        <h5 class="text-dark border-bottom border-warning pb-2">
                            <i class="bi bi-card-text text-warning me-2"></i>Описание
                        </h5>
                        <p class="text-dark lead"><?= Html::encode($model->description) ?></p>
                    </div>
                    
                    <!-- Категория -->
                    <div class="mb-4">
                        <h5 class="text-dark border-bottom border-warning pb-2">
                            <i class="bi bi-tags text-warning me-2"></i>Категория
                        </h5>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-warning text-dark fs-6 p-2">
                                <i class="bi bi-tag-fill me-2"></i><?= Html::encode($model->kategoty) ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Кнопки действий -->
                    <div class="mt-auto">
                        <div class="d-grid gap-3">
                            <!-- Кнопка "В корзину" -->
                            <a href="<?= Url::to(['carts/add', 'product_id' => $model->id]) ?>" 
                               class="btn btn-warning text-dark btn-lg fw-bold">
                                <i class="bi bi-cart-plus-fill me-2"></i>Добавить в корзину
                            </a>
                            
                            <!-- Кнопка "Назад" -->
                            <a href="<?= Url::to(['product/all']) ?>" 
                               class="btn btn-outline-dark btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Назад к товарам
                            </a>
                        </div>
                        
                        <!-- Админские кнопки -->
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_role == 2): ?>
                            <hr class="my-4">
                            <h6 class="text-dark mb-3"><i class="bi bi-shield-fill text-warning me-2"></i>Панель администратора</h6>
                            <div class="d-flex gap-2">
                                <a href="<?= Url::to(['product/update', 'id' => $model->id]) ?>" 
                                   class="btn btn-outline-warning flex-fill">
                                    <i class="bi bi-pencil-square me-1"></i>Редактировать
                                </a>
                                <a href="<?= Url::to(['product/delete', 'id' => $model->id]) ?>" 
                                   class="btn btn-outline-danger flex-fill" 
                                   data-confirm="Вы уверены, что хотите удалить этот товар?"
                                   data-method="post">
                                    <i class="bi bi-trash me-1"></i>Удалить
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Детальная информация -->
    <div class="card border-warning shadow mt-5">
        <div class="card-header bg-dark">
            <h4 class="text-warning mb-0">
                <i class="bi bi-clipboard-data-fill me-2"></i>Технические характеристики
            </h4>
        </div>
        <div class="card-body bg-light">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-borderless'],
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => '<i class="bi bi-hash text-warning"></i> ID',
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-dark'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                    [
                        'attribute' => 'name',
                        'label' => '<i class="bi bi-cup-straw text-warning"></i> Название',
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-dark fw-bold'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                    [
                        'attribute' => 'kategoty',
                        'label' => '<i class="bi bi-tag-fill text-warning"></i> Категория',
                        'format' => 'raw',
                        'value' => function($model) {
                            return '<span class="badge bg-warning text-dark">' . $model->kategoty . '</span>';
                        },
                        'contentOptions' => ['class' => 'text-dark'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                    [
                        'attribute' => 'description',
                        'label' => '<i class="bi bi-card-text text-warning"></i> Описание',
                        'format' => 'ntext',
                        'contentOptions' => ['class' => 'text-dark'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                    [
                        'attribute' => 'cost',
                        'label' => '<i class="bi bi-currency-dollar text-warning"></i> Цена',
                        'value' => function($model) {
                            return '<span class="text-dark fw-bold">' . $model->cost . ' ₽</span>';
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'text-dark'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                    [
                        'attribute' => 'photo',
                        'label' => '<i class="bi bi-image text-warning"></i> Фото',
                        'format' => 'raw',
                        'value' => function($model) {
                            if (!empty($model->photo) && $model->photo !== 'а') {
                                return Html::img($model->photo, [
                                    'style' => 'max-width: 150px; max-height: 150px;',
                                    'class' => 'img-thumbnail border-warning'
                                ]);
                            }
                            return '<span class="text-muted">Отсутствует</span>';
                        },
                        'contentOptions' => ['class' => 'text-dark'],
                        'labelOptions' => ['class' => 'text-dark']
                    ],
                ],
            ]) ?>
        </div>
    </div>
    
    <!-- Похожие товары -->
    <?php
    $similarProducts = \app\models\Product::find()
        ->where(['kategoty' => $model->kategoty])
        ->andWhere(['not', ['id' => $model->id]])
        ->limit(3)
        ->all();
    
    if (!empty($similarProducts)): ?>
        <div class="mt-5">
            <div class="card border-warning shadow">
                <div class="card-header bg-dark">
                    <h4 class="text-warning mb-0">
                        <i class="bi bi-arrow-repeat text-warning me-2"></i>Похожие товары
                    </h4>
                </div>
                <div class="card-body bg-light">
                    <div class="row g-4">
                        <?php foreach ($similarProducts as $similarProduct): ?>
                            <div class="col-md-4">
                                <?= $this->render('../site/_product_card', ['model' => $similarProduct]) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">