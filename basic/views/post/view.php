<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\HtmlPurifier;
/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Посты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h3><?= Html::encode($this->title) ?></h3>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Название',
                'value' => $model->title,
            ],
            [
                'label' => 'Аннос',
                'value' => $model->preview,
            ],
            [
                'label' => 'Контент',
                'format' => 'raw',
                'value' => HtmlPurifier::process($model->content),
            ],
            [
                'label' => 'Статус',
                'value' => $model->nameStatus,
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
        <?= Html::a('Редактироть', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
