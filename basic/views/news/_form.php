<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\Sourse;
use app\models\News;
use app\models\ParseKey;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'resourse_id')->dropDownList(ArrayHelper::map(Sourse::ddList(), 'id', 'name')) ?>

    <?= $form->field($model, 'parse_key_id')->dropDownList(ArrayHelper::map(ParseKey::ddList(), 'id', 'key')) ?>

    <?= $form->field($model, 'status')->dropDownList(News::ddStatus()) ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
