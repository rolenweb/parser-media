<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sourse */

$this->title = 'Редактирование ресурса: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ресурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="sourse-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
