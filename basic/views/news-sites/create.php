<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\NewsSites */

$this->title = 'Добавить новостной сайт';
$this->params['breadcrumbs'][] = ['label' => 'Новостные сайты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-sites-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
