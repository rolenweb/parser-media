<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NewsSitesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-sites-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'adres') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'manager') ?>

    <?php // echo $form->field($model, 'federal') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'rubric') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'CY') ?>

    <?php // echo $form->field($model, 'MLG') ?>

    <?php // echo $form->field($model, 'uri') ?>

    <?php // echo $form->field($model, 'region2') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'alexa_gk') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
