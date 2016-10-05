<?php

use yii\helpers\Html;

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
