<?php

use app\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var app\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои заказы';
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
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
            <li class="breadcrumb-item active text-dark" aria-current="page">
                <i class="bi bi-bag-check-fill text-warning me-1"></i>Мои заказы
            </li>
        </ol>
    </nav>

    <!-- Заголовок -->
    <h1 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-receipt text-warning me-3"></i>Мои заказы
    </h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= Yii::$app->session->getFlash('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($dataProvider->getModels())): ?>
        <!-- Нет заказов -->
        <div class="alert alert-dark text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                <i class="bi bi-bag-x display-1 text-warning"></i>
            </div>
            <h4 class="text-warning">У вас пока нет заказов</h4>
            <p class="text-light">Перейдите в корзину, чтобы оформить заказ</p>
            <div class="mt-4">
                <a href="<?= Url::to(['carts/index']) ?>" class="btn btn-warning text-dark me-3">
                    <i class="bi bi-cart-fill me-2"></i>Перейти в корзину
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-warning">
                    <i class="bi bi-shop me-2"></i>К товарам
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Статистика -->
        <?php
        $orders = $dataProvider->getModels();
        $totalOrders = count($orders);
        $paidOrders = 0;
        $totalAmount = 0;
        
        foreach ($orders as $order) {
            if ($order->status === 'Оплачено') {
                $paidOrders++;
            }
            if ($order->cart && is_numeric($order->cart->cost)) {
                $totalAmount += (float)$order->cart->cost;
            }
        }
        ?>
        
        <div class="card border-warning shadow mb-4">
            <div class="card-header bg-dark">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="text-warning mb-0">
                            <i class="bi bi-graph-up me-2"></i>
                            Статистика
                        </h5>
                    </div>
                    <div class="col-md-8">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="bg-warning rounded-pill px-3 py-1 d-inline-block">
                                    <span class="text-dark fw-bold"><?= $totalOrders ?></span>
                                </div>
                                <p class="text-light small mb-0 mt-1">Всего заказов</p>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light rounded-pill px-3 py-1 d-inline-block">
                                    <span class="text-dark fw-bold"><?= $paidOrders ?></span>
                                </div>
                                <p class="text-light small mb-0 mt-1">Оплачено</p>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-warning rounded-pill px-3 py-1 d-inline-block">
                                    <span class="text-dark fw-bold"><?= number_format($totalAmount, 0, '', ' ') ?> ₽</span>
                                </div>
                                <p class="text-light small mb-0 mt-1">Общая сумма</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Таблица заказов -->
        <div class="card border-warning shadow">
            <div class="card-header bg-dark">
                <h5 class="text-warning mb-0">
                    <i class="bi bi-list-columns-reverse me-2"></i>Список заказов
                </h5>
            </div>
            <div class="card-body bg-light p-0">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => ['class' => 'table table-hover mb-0'],
                        'columns' => [
                            [
                                'class' => SerialColumn::class,
                                'header' => '№',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'text-dark align-middle'],
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'Номер заказа',
                                'value' => function($model) {
                                    return '<span class="badge bg-dark text-light">#' . str_pad($model->id, 6, '0', STR_PAD_LEFT) . '</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],
                            [
                                'label' => 'Товар',
                                'value' => function($model) {
                                    if ($model->cart && $model->cart->product) {
                                        return Html::encode($model->cart->product->name);
                                    }
                                    return '<span class="text-muted">Товар удален</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'text-dark align-middle'],
                            ],
                            [
                                'attribute' => 'date',
                                'label' => 'Дата заказа',
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDatetime($model->date, 'php:d.m.Y H:i');
                                },
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'text-dark align-middle'],
                            ],
                            [
                                'attribute' => 'payment',
                                'label' => 'Способ оплаты',
                                'value' => function($model) {
                                    $badgeClass = $model->payment === 'Банковская карта' ? 'bg-primary' : 
                                                 ($model->payment === 'Кредит' ? 'bg-danger' : 'bg-success');
                                    return '<span class="badge ' . $badgeClass . '">' . Html::encode($model->payment) . '</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Статус',
                                'value' => function($model) {
                                    $badgeClass = $model->status === 'Оплачено' ? 'bg-success' : 'bg-warning text-dark';
                                    return '<span class="badge ' . $badgeClass . '">' . Html::encode($model->status) . '</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'align-middle'],
                            ],
                            [
                                'label' => 'Сумма',
                                'value' => function($model) {
                                    if ($model->cart && is_numeric($model->cart->cost)) {
                                        return '<span class="fw-bold text-dark">' . number_format($model->cart->cost, 2, '.', ' ') . ' ₽</span>';
                                    }
                                    return '<span class="text-muted">—</span>';
                                },
                                'format' => 'raw',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'text-dark align-middle'],
                            ],
                            [
                                'class' => ActionColumn::class,
                                'header' => 'Действия',
                                'headerOptions' => ['class' => 'text-dark'],
                                'contentOptions' => ['class' => 'text-center align-middle'],
                                'template' => '{view} {update} {cancel}',
                                'buttons' => [
                                    'view' => function($url, $model, $key) {
                                        return Html::a(
                                            '<i class="bi bi-eye"></i>',
                                            $url,
                                            [
                                                'class' => 'btn btn-sm btn-outline-dark',
                                                'title' => 'Просмотр',
                                                'data-pjax' => '0'
                                            ]
                                        );
                                    },
                                    'update' => function($url, $model, $key) {
                                        return Html::a(
                                            '<i class="bi bi-pencil"></i>',
                                            $url,
                                            [
                                                'class' => 'btn btn-sm btn-outline-warning',
                                                'title' => 'Редактировать',
                                                'data-pjax' => '0'
                                            ]
                                        );
                                    },
                                    'cancel' => function($url, $model, $key) {
                                        return Html::a(
                                            '<i class="bi bi-x-circle"></i>',
                                            ['cancel', 'id' => $model->id],
                                            [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'title' => 'Отменить заказ',
                                                'data-confirm' => 'Вы уверены, что хотите отменить этот заказ?',
                                                'data-method' => 'post',
                                                'data-pjax' => '0'
                                            ]
                                        );
                                    },
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($action === 'cancel') {
                                        return ['cancel', 'id' => $model->id];
                                    }
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                            ],
                        ],
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
            </div>
        </div>

        <!-- Кнопки навигации -->
        <div class="mt-4 text-center">
            <div class="btn-group" role="group">
                <a href="<?= Url::to(['carts/index']) ?>" class="btn btn-warning text-dark">
                    <i class="bi bi-cart-fill me-2"></i>В корзину
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-dark ms-2">
                    <i class="bi bi-shop me-2"></i>К товарам
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-warning ms-2">
                    <i class="bi bi-house-door me-2"></i>На главную
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">