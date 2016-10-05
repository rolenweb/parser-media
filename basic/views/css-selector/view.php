<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->registerJsFile('@web/js/css-selector.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
/* @var $this yii\web\View */
/* @var $model app\models\CssSelector */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Css Селекторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginTag('div',['class' => 'css-selector-view']);
    echo Html::tag('h3',Html::encode($this->title));
    echo DetailView::widget([
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
    ]);

    echo Html::beginTag('p',['class' => 'text-right']);
        echo Html::beginTag('ul',['class' => 'list-inline text-right']);
            echo Html::beginTag('li');
                if ($model->newsSite !== null) {
                    echo Html::input('text', 'test-url', '', ['class' => 'form-control form-inline']);
                }
            echo Html::endTag('li');
            echo Html::beginTag('li');
                echo Html::button('Тест',['class' => 'btn btn-default','name' => 'test-css-selector', 'css-selector' => $model->id]);
            echo Html::endTag('li');
            echo Html::beginTag('li');
                echo Html::a('Редатировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::endTag('li');
            echo Html::beginTag('li');
                echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены что хотите удалить?',
                    'method' => 'post',
                ],
            ]);
            echo Html::endTag('li');
        echo Html::endTag('ul');
        
        
        
        
    echo Html::endTag('p');
    echo Html::beginTag('p',['class' => 'block-result-test']);

    echo Html::endTag('p');
echo Html::endTag('div');
?>
