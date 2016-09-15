<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ParseKey */

$this->title = 'Добавить ключ';
$this->params['breadcrumbs'][] = ['label' => 'Ключи для парсинга', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parse-key-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
