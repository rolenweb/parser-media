<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CssSelector */

$this->title = 'Добавить Css Селектор';
$this->params['breadcrumbs'][] = ['label' => 'Css Селекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-selector-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'sourse' => $sourse,
        'news' => $news,
    ]) ?>

</div>
