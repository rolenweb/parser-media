<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use app\models\ParseKey;
use app\models\Sourse;

/* @var $this yii\web\View */
/* @var $model app\models\ParseKey */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parse-key-form">

    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type')->dropDownList(ParseKey::ddType()) ?>

            <?= $form->field($model, 'sourse_id')->dropDownList(ArrayHelper::map(Sourse::ddList(), 'id', 'name')) ?>

            <?= $form->field($model, 'status')->dropDownList(ParseKey::ddStatus()) ?>

    
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>        
        </div>
    </div>

</div>
