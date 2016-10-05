<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CssSelectorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Css cелекторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="css-selector-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'name',
                'label' => 'Название',
               
            ],
            
            [
                'attribute'=>'selector',
                'label' => 'Селектор',
                //'enableSorting' => true,
               
            ],
            
            [
                'attribute'=>'type',
                'label' => 'Тип',
               
            ],
            
            [
                'attribute'=>'sourse_id',
                'label' => 'Ресурс',
                'content' => function($data){
                    return ($data->sourse !== null) ? Html::a($data->sourse->name,['sourse/view','id' => $data->sourse->id]) : 'нет';
                }
               
            ],
            
            [
                'attribute'=>'news_id',
                'label' => 'Новостной сайт',
                'content' => function($data){
                    return ($data->newsSite !== null) ? Html::a($data->newsSite->name,['news-sites/view','id' => $data->newsSite->id]) : 'нет';
                }
               
            ],
            [
                'attribute'=>'created_at',
                'label' => 'Создана',
                'content'=>function($data){
                    return date("d/m/Y",$data->created_at);
                }
                
            ],
            [
                'attribute'=>'updated_at',
                'label' => 'Обновлена',
                'content'=>function($data){
                    return date("d/m/Y",$data->updated_at);
                }
                
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>
