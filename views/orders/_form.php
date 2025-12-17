<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment')->dropDownList([ 'Наличные' => 'Наличные', 'Банковская карта' => 'Банковская карта', 'Кредит' => 'Кредит', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Оплачено' => 'Оплачено', 'Ожидает оплаты' => 'Ожидает оплаты', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
