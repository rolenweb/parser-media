<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\NewsSites */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Новостные сайты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div',['class' => 'news-sites-view']);
    echo Html::tag('h3',Html::encode($this->title));
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'email:email',
            'adres',
            'telephone',
            'manager',
            'federal',
            'region',
            'rubric',
            'type',
            'CY',
            'MLG',
            'uri',
            'region2',
            'site',
            'alexa_gk',
            'comment',
            [
                'label' => 'Полнотекст',
                'value' => ($model->fulltext === $model::FULLTEXT_YES) ? 'Да' : 'Нет',
            ],
        ],
    ]);
    echo Html::beginTag('p',['class' => 'text-right']);
        echo Html::a('Добавить CSS селектор', ['css-selector/create', 'news' => $model->id], ['class' => 'btn btn-default','target' => '_blank']);
        echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить сайт?',
                'method' => 'post',
            ],
        ]);
    echo Html::endTag('p');

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'name',
                'label' => 'Название',
                'enableSorting' => false,
               
            ],
            [
                'attribute'=>'selector',
                'label' => 'Селектор',
                'enableSorting' => false,
               
            ],
            [
                'attribute'=>'type',
                'label' => 'Тип',
                'enableSorting' => false,
               
            ],
            [
                'attribute'=>'created_at',
                'label' => 'Создана',
                'content'=>function($data){
                    return date("d/m/Y",$data->created_at);
                },
                'enableSorting' => false,
                
            ],
            [
                'attribute'=>'updated_at',
                'label' => 'Обновлена',
                'content'=>function($data){
                    return date("d/m/Y",$data->updated_at);
                },
                'enableSorting' => false,
                
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update') {
                            $url ='/css-selector/update?id='.$model->id;
                            return $url;
                    }
                },


            ],
        ],
    ]);

echo Html::endTag('div');
?>
