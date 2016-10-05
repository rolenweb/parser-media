<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NewsSites */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Новостные сайты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="news-sites-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
