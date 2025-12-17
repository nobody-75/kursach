<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'О нас';
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
                <i class="bi bi-info-circle-fill text-warning me-1"></i>О нас
            </li>
        </ol>
    </nav>

    <!-- Заголовок -->
    <div class="text-center mb-5">
        <h1 class="text-dark border-bottom border-warning pb-3 d-inline-block">
            <i class="bi bi-cup-hot-fill text-warning me-3"></i>О нашей компании
        </h1>
        <p class="lead text-dark mt-3">Мы создаем кофейную культуру с 2022 года</p>
    </div>

    <!-- Миссия -->
    <div class="card border-warning shadow mb-5">
        <div class="card-header bg-dark">
            <h3 class="text-warning mb-0">
                <i class="bi bi-bullseye me-2"></i>Наша миссия
            </h3>
        </div>
        <div class="card-body bg-light">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <p class="text-dark fs-5">
                        Мы верим, что каждый день должен начинаться с идеальной чашки кофе. 
                        Наша миссия — делать качественный кофе доступным для каждого ценителя, 
                        сохраняя традиции и внедряя инновации.
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="bg-dark rounded-circle d-inline-flex p-4">
                        <i class="bi bi-cup text-warning display-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- История -->
    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card border-warning shadow h-100">
                <div class="card-header bg-dark">
                    <h3 class="text-warning mb-0">
                        <i class="bi bi-clock-history me-2"></i>Наша история
                    </h3>
                </div>
                <div class="card-body bg-light">
                    <p class="text-dark">
                        Все началось с маленькой кофейни в центре города в 2022 году. 
                        Мы начали с продажи нескольких сортов кофе, но страсть к качеству 
                        и любовь клиентов помогли нам вырасти в полноценный онлайн-магазин.
                    </p>
                    <p class="text-dark">
                        Сегодня мы сотрудничаем с плантациями из Бразилии, Колумбии, 
                        Эфиопии и Вьетнама, чтобы предложить вам лучшее.
                    </p>
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                            <span class="text-dark">2022 — Открытие первой кофейни</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                            <span class="text-dark">2023 — Запуск онлайн-магазина</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                            <span class="text-dark">2024 — Расширение ассортимента до 100+ товаров</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card border-warning shadow h-100">
                <div class="card-header bg-dark">
                    <h3 class="text-warning mb-0">
                        <i class="bi bi-shop me-2"></i>Что мы предлагаем
                    </h3>
                </div>
                <div class="card-body bg-light">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="bi bi-droplet-fill text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-1">Кофе в зернах</h6>
                                    <p class="text-dark small mb-0">Arabica, Robusta, уникальные смеси</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="bi bi-mortarboard-fill text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-1">Молотый кофе</h6>
                                    <p class="text-dark small mb-0">Разные степени помола для любого способа заваривания</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="bi bi-gear-fill text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-1">Оборудование</h6>
                                    <p class="text-dark small mb-0">Турки, френч-прессы, кофеварки</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-warning rounded-circle p-2 me-3">
                                    <i class="bi bi-gift-fill text-dark"></i>
                                </div>
                                <div>
                                    <h6 class="text-dark fw-bold mb-1">Аксессуары</h6>
                                    <p class="text-dark small mb-0">Чашки, ложки, фильтры и многое другое</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Преимущества -->
    <div class="container-fluid bg-dark py-5 mb-5 rounded">
        <div class="container">
            <h2 class="text-center text-warning mb-5">
                <i class="bi bi-star-fill me-2"></i>Наши преимущества
            </h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-check2-circle text-warning fs-1"></i>
                        </div>
                        <h5 class="text-light">Контроль качества</h5>
                        <p class="text-muted">Каждая партия проходит строгий отбор</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-truck text-warning fs-1"></i>
                        </div>
                        <h5 class="text-light">Быстрая доставка</h5>
                        <p class="text-muted">Доставляем по России за 1-3 дня</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-coin text-warning fs-1"></i>
                        </div>
                        <h5 class="text-light">Честные цены</h5>
                        <p class="text-muted">Без посредников и накруток</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="text-center">
                        <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-chat-heart text-warning fs-1"></i>
                        </div>
                        <h5 class="text-light">Экспертная поддержка</h5>
                        <p class="text-muted">Поможем выбрать идеальный кофе</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ценности -->
    <div class="card border-warning shadow mb-5">
        <div class="card-header bg-dark">
            <h3 class="text-warning mb-0">
                <i class="bi bi-heart-fill me-2"></i>Наши ценности
            </h3>
        </div>
        <div class="card-body bg-light">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center p-3">
                        <div class="bg-warning rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-award-fill text-dark fs-2"></i>
                        </div>
                        <h5 class="text-dark">Качество</h5>
                        <p class="text-dark">Не идем на компромиссы в качестве продукции</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3">
                        <div class="bg-warning rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-people-fill text-dark fs-2"></i>
                        </div>
                        <h5 class="text-dark">Клиентоориентированность</h5>
                        <p class="text-dark">Каждый клиент для нас — часть кофейного сообщества</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center p-3">
                        <div class="bg-warning rounded-circle d-inline-flex p-3 mb-3">
                            <i class="bi bi-tree-fill text-dark fs-2"></i>
                        </div>
                        <h5 class="text-dark">Устойчивое развитие</h5>
                        <p class="text-dark">Работаем с плантациями, которые заботятся об экологии</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Контакты -->
    <div class="card border-warning shadow">
        <div class="card-header bg-dark">
            <h3 class="text-warning mb-0">
                <i class="bi bi-geo-alt-fill me-2"></i>Контакты
            </h3>
        </div>
        <div class="card-body bg-light">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-dark rounded-circle p-2 me-3">
                            <i class="bi bi-geo-alt text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-dark fw-bold">Адрес</h6>
                            <p class="text-dark mb-0">г. Москва, ул. Кофейная, д. 15</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-dark rounded-circle p-2 me-3">
                            <i class="bi bi-clock text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-dark fw-bold">Время работы</h6>
                            <p class="text-dark mb-0">Пн-Пт: 9:00-20:00<br>Сб-Вс: 10:00-18:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-dark rounded-circle p-2 me-3">
                            <i class="bi bi-telephone text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-dark fw-bold">Телефон</h6>
                            <p class="text-dark mb-0">+7 (999) 123-45-67</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-dark rounded-circle p-2 me-3">
                            <i class="bi bi-envelope text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-dark fw-bold">Email</h6>
                            <p class="text-dark mb-0">info@coffee-shop.ru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Призыв к действию -->
    <div class="text-center mt-5 pt-4">
        <div class="alert alert-warning border-warning">
            <h4 class="text-dark mb-3">Готовы открыть для себя мир кофе?</h4>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?= Url::to(['product/all']) ?>" class="btn btn-dark">
                    <i class="bi bi-cup-straw me-2"></i>Перейти к каталогу
                </a>
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-outline-dark">
                    <i class="bi bi-arrow-left me-2"></i>На главную
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Подключение Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">