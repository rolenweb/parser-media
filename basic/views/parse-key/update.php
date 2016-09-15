<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ParseKey */

$this->title = 'Редактирование ключа: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Ключи для парсинга', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="parse-key-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
