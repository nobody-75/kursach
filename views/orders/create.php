<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var app\models\Carts $cart */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['carts/index']];
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
            <li class="breadcrumb-item">
                <a href="<?= Url::to(['carts/index']) ?>" class="text-decoration-none text-warning">
                    <i class="bi bi-cart-fill me-1"></i>Корзина
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                <i class="bi bi-bag-check-fill text-warning me-1"></i>Оформление заказа
            </li>
        </ol>
    </nav>

    <!-- Заголовок -->
    <h1 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-cart-check text-warning me-3"></i>Оформление заказа
    </h1>

    <!-- Информация о товаре -->
    <?php if (isset($cart) && $cart): ?>
    <div class="card border-warning shadow mb-4">
        <div class="card-header bg-dark">
            <h5 class="text-warning mb-0">
                <i class="bi bi-box-seam me-2"></i>Информация о товаре
            </h5>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="text-dark">
                        <?= $cart->product ? Html::encode($cart->product->name) : 'Товар удален' ?>
                    </h5>
                    <p class="text-muted mb-1">
                        Категория: 
                        <?php if ($cart->product): ?>
                            <span class="badge bg-warning text-dark"><?= Html::encode($cart->product->kategoty) ?></span>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <h4 class="text-dark fw-bold">
                        <?= number_format($cart->cost, 2, '.', ' ') ?> ₽
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Форма оформления заказа -->
    <div class="card border-warning shadow">
        <div class="card-header bg-dark">
            <h5 class="text-warning mb-0">
                <i class="bi bi-credit-card me-2"></i>Данные для заказа
            </h5>
        </div>
        <div class="card-body bg-light">
            <?php $form = \yii\widgets\ActiveForm::begin([
                'options' => ['class' => 'needs-validation'],
            ]); ?>
            
            <!-- Скрытое поле carts_id -->
            <?php if (isset($cart) && $cart): ?>
                <?= $form->field($model, 'carts_id')->hiddenInput(['value' => $cart->id])->label(false) ?>
            <?php else: ?>
                <?= $form->field($model, 'carts_id')->textInput([
                    'type' => 'number',
                    'class' => 'form-control'
                ])->label('ID корзины') ?>
            <?php endif; ?>
            
            <!-- Способ оплаты -->
            <div class="mb-4">
                <h6 class="text-dark border-bottom pb-2 mb-3">
                    <i class="bi bi-cash-stack text-warning me-2"></i>Способ оплаты
                </h6>
                <?= $form->field($model, 'payment')->radioList([
                    'Наличные' => '<i class="bi bi-cash-coin me-2"></i>Наличные',
                    'Банковская карта' => '<i class="bi bi-credit-card me-2"></i>Банковская карта',
                    'Кредит' => '<i class="bi bi-bank me-2"></i>Кредит',
                ], [
                    'item' => function($index, $label, $name, $checked, $value) {
                        $checked = $checked ? 'checked' : '';
                        $active = $checked ? 'active' : '';
                        return "
                            <div class='form-check mb-2'>
                                <input class='form-check-input' type='radio' name='{$name}' id='payment{$index}' value='{$value}' {$checked}>
                                <label class='form-check-label btn btn-outline-dark w-100 text-start' for='payment{$index}'>
                                    {$label}
                                </label>
                            </div>
                        ";
                    }
                ])->label(false) ?>
            </div>
            
            <!-- Статус (скрытое поле) -->
            <?= $form->field($model, 'status')->hiddenInput(['value' => 'Ожидает оплаты'])->label(false) ?>
            
            <!-- Дата (скрытое поле) -->
            <?= $form->field($model, 'date')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>
            
            <!-- Кнопки -->
            <div class="form-group mt-4 pt-3 border-top">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <a href="<?= Url::to(['carts/index']) ?>" class="btn btn-outline-dark w-100">
                            <i class="bi bi-arrow-left me-2"></i>Вернуться в корзину
                        </a>
                    </div>
                    <div class="col-md-6">
                        <?= Html::submitButton('<i class="bi bi-check-circle me-2"></i>Оформить заказ', [
                            'class' => 'btn btn-warning text-dark w-100 fw-bold'
                        ]) ?>
                    </div>
                </div>
            </div>
            
            <?php \yii\widgets\ActiveForm::end(); ?>
        </div>
    </div>
    
    <!-- Информация -->
    <div class="alert alert-dark mt-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-warning"><i class="bi bi-info-circle me-2"></i>Важно</h6>
                <p class="text-light small mb-0">
                    После оформления заказа вы сможете отслеживать его статус в разделе "Мои заказы"
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-warning"><i class="bi bi-shield-check me-2"></i>Безопасность</h6>
                <p class="text-light small mb-0">
                    Все данные защищены. Мы не передаем вашу информацию третьим лицам
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
.form-check-input:checked + .btn-outline-dark {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}
.form-check-input {
    display: none;
}
</style>