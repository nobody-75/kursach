<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<a href="/user/index">Редактировать пользователей</a>
<a href="/orders/index">Редактировать заказы</a>
<a href="/product/index">Редактировать товары</a>
</div>
