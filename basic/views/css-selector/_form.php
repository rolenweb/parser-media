<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\CssSelector;

/* @var $this yii\web\View */
/* @var $model app\models\CssSelector */
/* @var $form yii\widgets\ActiveForm */
if (empty($sourse) === false) {
    $model->sourse_id = $sourse;
}
if (empty($news) === false) {
    $model->news_id = $news;
}


?>

<div class="css-selector-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'selector')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(CssSelector::ddType()) ?>

    <?= $form->field($model, 'sourse_id')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'news_id')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>



    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
