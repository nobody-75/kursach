<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Product[] $products */
/** @var string $category */
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
                <a href="<?= Url::to(['site/index']) ?>" class="text-decoration-none text-warning">
                    <i class="bi bi-tags-fill me-1"></i>Категории
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                <i class="bi bi-tag-fill text-warning me-1"></i><?= Html::encode($category) ?>
            </li>
        </ol>
    </nav>

    <!-- Заголовок категории -->
    <div class="text-center mb-5">
        <div class="d-inline-block p-4 bg-dark rounded-3 shadow">
            <h1 class="text-warning mb-0">
                <i class="bi bi-folder2-open me-3"></i>Категория: <?= Html::encode($category) ?>
            </h1>
            <p class="text-light mt-2 mb-0">
                <i class="bi bi-box-seam me-1"></i>Товары в данной категории
            </p>
        </div>
    </div>
    
    <?php if (!empty($products)): ?>
        <!-- Счетчик товаров -->
        <div class="alert alert-dark mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <i class="bi bi-info-circle-fill text-warning me-2"></i>
                    Найдено товаров в категории 
                    <span class="badge bg-warning text-dark fs-6 ms-2"><?= count($products) ?></span>
                </div>
                <div class="col-md-4 text-end">
                    <a href="<?= Url::to(['product/all']) ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-grid-3x3-gap me-1"></i>Все товары
                    </a>
                </div>
            </div>
        </div>

        <!-- Карточки товаров -->
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <?= $this->render('../site/_product_card', ['model' => $product]) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Навигация -->
        <div class="mt-5 pt-4 border-top border-secondary text-center">
            <div class="btn-group" role="group">
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-warning">
                    <i class="bi bi-arrow-left me-2"></i>Назад к категориям
                </a>
                <a href="<?= Url::to(['product/all']) ?>" class="btn btn-warning text-dark ms-2">
                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Все товары
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-dark ms-2">
                    <i class="bi bi-house-door me-2"></i>На главную
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center py-5 my-5">
            <i class="bi bi-inbox-fill display-4 text-warning mb-3"></i>
            <h4 class="text-dark">В этой категории пока нет товаров</h4>
            <p class="text-muted mt-3">Но мы обязательно добавим их в ближайшее время!</p>
            <div class="mt-4">
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-warning text-dark">
                    <i class="bi bi-tags-fill me-2"></i>Вернуться к категориям
                </a>
                <a href="<?= Url::to(['product/all']) ?>" class="btn btn-outline-warning ms-3">
                    <i class="bi bi-grid-3x3-gap me-2"></i>Посмотреть все товары
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">