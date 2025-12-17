<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Product[] $products */
/** @var string $category */

$this->title = 'Категория: ' . Html::encode($category);
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-category">
    <h1 class="text-center mb-4"><?= Html::encode($category) ?></h1>
    
    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <?= $this->render('_product_card', ['model' => $product]) ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            В этой категории пока нет товаров
            <div class="mt-3">
                <a href="<?= Url::to(['site/index']) ?>" class="btn btn-primary">
                    Вернуться к категориям
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>