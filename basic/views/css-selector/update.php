<?php

use yii\helpers\Html;
$this->registerCssFile('@web/css/css-selector.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerJsFile('@web/js/css-selector.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */
/* @var $model app\models\CssSelector */

$this->title = 'Редатировать Css Селектор: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Css Селекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="css-selector-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
