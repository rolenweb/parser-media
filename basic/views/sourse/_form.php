<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Sourse;

/* @var $this yii\web\View */
/* @var $model app\models\Sourse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sourse-form">

    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'type')->dropDownList(Sourse::ddType()) ?>

            <?= $form->field($model, 'status')->dropDownList(Sourse::ddStatus()) ?>

    
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>        
        </div>
    </div>
    

</div>
