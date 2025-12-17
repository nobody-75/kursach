<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Product[] $products */


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
                <i class="bi bi-grid-3x3-gap-fill me-1"></i>Все товары
            </li>
        </ol>
    </nav>

    <!-- Заголовок -->
    <h1 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-box-seam-fill text-warning me-3"></i>Все товары
    </h1>
    
    <?php if (!empty($products)): ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <?= $this->render('../site/_product_card', ['model' => $product]) ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Статистика -->
        <div class="mt-5 pt-4 border-top border-secondary text-center">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-dark text-light">
                        <i class="bi bi-info-circle-fill text-warning me-2"></i>
                        Показано <span class="badge bg-warning text-dark"><?= count($products) ?></span> товаров
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center py-5 my-5">
            <i class="bi bi-exclamation-triangle-fill display-4 text-warning mb-3"></i>
            <h4 class="text-dark">Товары временно отсутствуют</h4>
            <p class="text-muted mt-3">Загляните позже или ознакомьтесь с другими категориями</p>
            <div class="mt-4">
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-warning">
                    <i class="bi bi-arrow-left me-2"></i>Вернуться на главную
                </a>
                <a href="<?= Url::to(['product/categories']) ?>" class="btn btn-warning text-dark ms-2">
                    <i class="bi bi-tags-fill me-2"></i>Посмотреть категории
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">