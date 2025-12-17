<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model app\models\Product */
?>

<div class="card h-100 border-warning shadow-sm">
    <!-- Заголовок карточки -->
    <div class="card-header bg-dark py-2">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-warning small fw-bold">
                <i class="bi bi-tag-fill me-1"></i><?= Html::encode($model->kategoty) ?>
            </span>
            <?php if ($model->is_new ?? false): ?>
                <span class="badge bg-warning text-dark">NEW</span>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Фото товара -->
    <?php if (!empty($model->photo)): ?>
        <img src="<?= Html::encode($model->photo) ?>" class="card-img-top" alt="<?= Html::encode($model->name) ?>" 
             style="height: 200px; object-fit: cover;">
    <?php else: ?>
        <div class="card-img-top bg-dark bg-opacity-10 d-flex align-items-center justify-content-center" 
             style="height: 200px;">
            <span class="text-muted">
                <i class="bi bi-image display-6"></i>
            </span>
        </div>
    <?php endif; ?>
    
    <!-- Тело карточки -->
    <div class="card-body d-flex flex-column bg-light">
        <!-- Название товара -->
        <h6 class="card-title fw-bold text-dark mb-2">
            <i class="bi bi-cup-straw text-warning me-2"></i>
            <?= Html::encode($model->name) ?>
        </h6>
        
        <!-- Описание -->
        <p class="card-text text-dark small flex-grow-1">
            <?= Html::encode(mb_strlen($model->description) > 100 ? mb_substr($model->description, 0, 100) . '...' : $model->description) ?>
        </p>
        
        <!-- Цена -->
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="text-muted small">Цена:</span>
                    <div class="fw-bold fs-5 text-dark">
                        <?= Html::encode($model->cost) ?> ₽
                    </div>
                </div>
                <?php if ($model->weight ?? false): ?>
                    <span class="badge bg-dark text-light small">
                        <?= Html::encode($model->weight) ?>г
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Кнопки действий -->
            <div class="d-flex justify-content-between">
                <a href="<?= Url::to(['carts/add', 'product_id' => $model->id]) ?>" 
                   class="btn btn-warning text-dark btn-sm fw-bold flex-fill me-2">
                    <i class="bi bi-cart-plus me-1"></i>В корзину
                </a>
                <a href="<?= Url::to(['product/view', 'id' => $model->id]) ?>" 
                   class="btn btn-outline-dark btn-sm flex-fill">
                    <i class="bi bi-eye me-1"></i>Подробнее
                </a>
            </div>
        </div>
    </div>
    
    <!-- Футер карточки (если нужно) -->
    <div class="card-footer bg-dark bg-opacity-10 py-2">
        <small class="text-muted">
            <i class="bi bi-clock-history me-1"></i>Доступно для заказа
        </small>
    </div>
</div>