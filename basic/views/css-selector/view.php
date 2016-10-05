<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CssSelector */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Css Селекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-selector-view">

    <h3><?= Html::encode($this->title) ?></h3>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Название',
                'value' => $model->name,
            ],
            [
                'label' => 'Селектор',
                'value' => $model->selector,
            ],
            [
                'label' => 'Тип',
                'value' => $model->type,
            ],
            [
                'label' => 'Ресурс',
                'format' => 'raw',
                'value' => ($model->sourse !== null) ? Html::a($model->sourse->name,['sourse/view','id' => $model->sourse->id]) : 'нет',
            ],
            [
                'label' => 'Новостной сайт',
                'format' => 'raw',
                'value' => ($model->newsSite !== null) ? Html::a($model->newsSite->name,['news-sites/view','id' => $model->newsSite->id]) : 'нет',
            ],
            [
                'label' => 'Создана',
                'value' => date("d/m/Y",$model->created_at),
            ],
            [
                'label' => 'Обновлена',
                'value' => date("d/m/Y",$model->updated_at),
            ],
        ],
    ]) ?>

    <p class="text-right">
        <?= Html::a('Редатировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
