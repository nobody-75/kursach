<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;
/** @var yii\web\View $this */
/** @var app\models\Product[] $categories */

?>

<div class="container-fluid px-0">
    <!-- Карусель -->
    <div class="carousel slide shadow-lg" id="carouselExampleIndicators" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner rounded-0" style="height: 500px;">
            <div class="carousel-item active">
                <img src="/web/img/abc.jpg" class="d-block w-100 h-100 opacity-75" alt="..." style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block start-0 end-0 bg-dark bg-opacity-50 p-4 rounded">
                    <h3 class="text-warning fw-bold">Ароматный кофе</h3>
                    <p class="text-light">Свежеобжаренные зерна для истинных ценителей</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/web/img/abc.jpg" class="d-block w-100 h-100 opacity-75" alt="..." style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block start-0 end-0 bg-dark bg-opacity-50 p-4 rounded">
                    <h3 class="text-warning fw-bold">Кофейное оборудование</h3>
                    <p class="text-light">Профессиональная техника для идеального напитка</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="/web/img/abc.jpg" class="d-block w-100 h-100 opacity-75" alt="..." style="object-fit: cover;">
                <div class="carousel-caption d-none d-md-block start-0 end-0 bg-dark bg-opacity-50 p-4 rounded">
                    <h3 class="text-warning fw-bold">Аксессуары</h3>
                    <p class="text-light">Все для кофейного ритуала</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark bg-opacity-50 rounded p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark bg-opacity-50 rounded p-3" aria-hidden="true"></span>
            <span class="visually-hidden">Следующий</span>
        </button>
    </div>
</div>

<!-- Секция с категориями -->
<div class="container mt-5">
    <h2 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-cup-hot me-2 text-warning"></i>Категории товаров
    </h2>
    
    <?php if (!empty($categories)): ?>
        <div class="row g-4">
            <?php foreach ($categories as $category): ?>
                <?php if (!empty($category->kategoty)): ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 border-warning shadow-sm">
                            <div class="card-header bg-dark text-white text-center py-3">
                                <i class="bi bi-tag-fill text-warning me-2"></i>
                                <span class="fw-bold"><?= Html::encode($category->kategoty) ?></span>
                            </div>
                            <div class="card-body d-flex flex-column text-center">
                                <?php
                                $productCount = Product::find()
                                    ->where(['kategoty' => $category->kategoty])
                                    ->count();
                                ?>
                                <div class="mt-auto">
                                    <div class="mb-3">
                                        <span class="badge bg-warning text-dark fs-6 p-2">
                                            <i class="bi bi-box-seam me-1"></i>
                                            <?= $productCount ?> товаров
                                        </span>
                                    </div>
                                    <a href="<?= Url::to(['product/category', 'category' => $category->kategoty]) ?>" 
                                       class="btn btn-warning text-dark fw-bold w-100">
                                        <i class="bi bi-eye me-2"></i>Смотреть
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Категории не найдены
        </div>
    <?php endif; ?>
    
    <!-- Кнопка для просмотра всех товаров -->
    <div class="text-center mt-5 pt-4 border-top border-secondary">
        <?php $totalProducts = Product::find()->count(); ?>
        <a href="<?= Url::to(['product/all']) ?>" class="btn btn-outline-warning btn-lg px-5">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i>
            Посмотреть все товары
            <span class="badge bg-dark text-warning ms-2"><?= $totalProducts ?></span>
        </a>
    </div>
</div>

<!-- Секция популярных товаров -->
<div class="container mt-5 pt-5">
    <h2 class="text-center mb-5 border-bottom border-warning pb-3 text-dark">
        <i class="bi bi-fire text-warning me-2"></i>Популярные товары
    </h2>
    
    <?php
    // Получаем 4 случайных товара
    $popularProducts = Product::find()
        ->orderBy('RAND()')
        ->limit(4)
        ->all();
    
    if (!empty($popularProducts)): ?>
        <div class="row g-4">
            <?php foreach ($popularProducts as $product): ?>
                <div class="col-md-6 col-lg-3">
                    <?= $this->render('_product_card', ['model' => $product]) ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Кнопка "Все популярные" -->
        <div class="text-center mt-4">
            <a href="<?= Url::to(['product/all']) ?>" class="btn btn-outline-dark">
                <i class="bi bi-arrow-right me-2"></i>Смотреть все товары
            </a>
        </div>
        
    <?php else: ?>
        <div class="alert alert-dark text-center">
            <i class="bi bi-cup text-warning me-2"></i>
            <span class="text-light">Товары скоро появятся</span>
        </div>
    <?php endif; ?>
</div>

<!-- Секция преимуществ -->
<div class="container-fluid bg-dark mt-5 py-5">
    <div class="container">
        <h2 class="text-center text-warning mb-5">
            <i class="bi bi-star-fill me-2"></i>Почему выбирают нас
        </h2>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-truck text-warning fs-1"></i>
                </div>
                <h5 class="text-light">Быстрая доставка</h5>
                <p class="text-muted">От 1 дня по всей России</p>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-gem text-warning fs-1"></i>
                </div>
                <h5 class="text-light">Качество премиум</h5>
                <p class="text-muted">Отборные зерна из лучших регионов</p>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-shield-check text-warning fs-1"></i>
                </div>
                <h5 class="text-light">Гарантия свежести</h5>
                <p class="text-muted">Свежая обжарка каждую неделю</p>
            </div>
            <div class="col-md-3">
                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-headset text-warning fs-1"></i>
                </div>
                <h5 class="text-light">Поддержка 24/7</h5>
                <p class="text-muted">Поможем с выбором в любое время</p>
            </div>
        </div>
    </div>
</div>

<!-- Баннер с акцией -->
<div class="container mt-5">
    <div class="alert alert-warning border-warning text-center py-4">
        <h3 class="text-dark">
            <i class="bi bi-percent text-dark me-2"></i>
            Скидка 15% на первую покупку!
        </h3>
        <p class="text-dark mb-0">Используйте промокод: <strong>COFFEE15</strong> при оформлении заказа</p>
        <div class="mt-3">
            <a href="<?= Url::to(['product/all']) ?>" class="btn btn-dark">
                <i class="bi bi-arrow-right me-2"></i>Воспользоваться скидкой
            </a>
        </div>
    </div>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">