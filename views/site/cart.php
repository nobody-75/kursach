<?php

use app\models\Carts;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;

// Получаем товары в корзине для текущего пользователя
$cartItems = [];
$totalSum = 0;

if (!Yii::$app->user->isGuest) {
    $cartItems = Carts::find()
        ->joinWith(['product'])
        ->where(['user_id' => Yii::$app->user->identity->id])
        ->all();
    
    foreach ($cartItems as $item) {
        if (is_numeric($item->cost)) {
            $totalSum += (float) $item->cost;
        }
    }
}
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
                <i class="bi bi-cart-fill text-warning me-1"></i>Корзина
            </li>
        </ol>
    </nav>

    <!-- Заголовок -->
    <h1 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-cart-check-fill text-warning me-3"></i>Ваша корзина
    </h1>

    <?php if (Yii::$app->user->isGuest): ?>
        <!-- Для гостей -->
        <div class="alert alert-warning text-center py-5">
            <i class="bi bi-person-x-fill display-4 text-warning mb-3"></i>
            <h4 class="text-dark">Для просмотра корзины необходимо авторизоваться</h4>
            <div class="mt-4">
                <a href="<?= Url::to(['login']) ?>" class="btn btn-warning text-dark me-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Войти
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-2"></i>На главную
                </a>
            </div>
        </div>
    <?php elseif (empty($cartItems)): ?>
        <!-- Пустая корзина -->
        <div class="alert alert-dark text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                <i class="bi bi-cart-x-fill display-1 text-warning"></i>
            </div>
            <h4 class="text-warning">Ваша корзина пуста</h4>
            <p class="text-light">Добавьте товары, чтобы они отобразились здесь</p>
            <div class="mt-4">
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-warning text-dark">
                    <i class="bi bi-cup-straw me-2"></i>Перейти к товарам
                </a>
                <a href="<?= Url::to(['product/all']) ?>" class="btn btn-outline-warning ms-3">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Все товары
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Информация о корзине -->
        <div class="card border-warning shadow mb-4">
            <div class="card-header bg-dark">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="text-warning mb-0">
                            <i class="bi bi-basket2-fill me-2"></i>
                            Товаров в корзине: 
                            <span class="badge bg-warning text-dark fs-6"><?= count($cartItems) ?></span>
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h4 class="text-warning mb-0">
                            <i class="bi bi-currency-dollar me-2"></i>
                            Общая сумма: <strong><?= number_format($totalSum, 2, '.', ' ') ?> ₽</strong>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Список товаров -->
        <div class="card border-warning shadow">
            <div class="card-header bg-dark">
                <h5 class="text-warning mb-0">
                    <i class="bi bi-list-check me-2"></i>Список товаров
                </h5>
            </div>
            <div class="card-body bg-light p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="bg-dark bg-opacity-10">
                                <th class="text-dark border-warning">№</th>
                                <th class="text-dark border-warning">Товар</th>
                                <th class="text-dark border-warning">Категория</th>
                                <th class="text-dark border-warning">Цена</th>
                                <th class="text-dark border-warning">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $index => $item): ?>
                            <tr class="border-warning">
                                <td class="text-dark align-middle">
                                    <span class="badge bg-dark text-light"><?= $index + 1 ?></span>
                                </td>
                                <td class="text-dark align-middle">
                                    <?php if ($item->product): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-cup-straw text-warning me-2"></i>
                                            <?= Html::encode($item->product->name) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-danger">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>Товар удален
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-dark align-middle">
                                    <?php if ($item->product): ?>
                                        <span class="badge bg-warning text-dark">
                                            <?= Html::encode($item->product->kategoty) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-dark align-middle fw-bold">
                                    <?= Html::encode($item->cost) ?> ₽
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <?php if ($item->product): ?>
                                            <a href="<?= Url::to(['product/view', 'id' => $item->product_id]) ?>" 
                                               class="btn btn-outline-dark btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= Url::to(['carts/delete', 'id' => $item->id]) ?>" 
                                           class="btn btn-outline-danger btn-sm"
                                           data-confirm="Удалить этот товар из корзины?"
                                           data-method="post">
                                            <i class="bi bi-trash"></i> Удалить
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Итоговая сумма -->
        <div class="card border-warning shadow mt-4">
            <div class="card-body bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="text-dark mb-0">
                            <i class="bi bi-receipt text-warning me-2"></i>Итоговая сумма заказа:
                        </h5>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h3 class="text-dark fw-bold mb-0">
                            <?= number_format($totalSum, 2, '.', ' ') ?> ₽
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Кнопки действий -->
        <div class="mt-5">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-dark">
                            <i class="bi bi-arrow-left me-2"></i>Продолжить покупки
                        </a>
                        <a href="<?= Url::to(['carts/clear']) ?>" 
                           class="btn btn-outline-danger"
                           data-confirm="Очистить всю корзину?"
                           data-method="post">
                            <i class="bi bi-trash-fill me-2"></i>Очистить корзину
                        </a>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= Url::to(['orders/create']) ?>" class="btn btn-warning text-dark btn-lg fw-bold">
                        <i class="bi bi-bag-check-fill me-2"></i>Оформить заказ
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">