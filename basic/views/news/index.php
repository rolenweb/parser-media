<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список новостей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'title',
                'label' => 'Название',
               
            ],
            
            [
                'attribute'=>'preview',
                'label' => 'Превью',
                'content'=>function($data){
                    return $data->preview;
                }
                
            ],
            'url:url',
            //'description_id',
            [
                'attribute'=>'resourse_id',
                'label' => 'Ресурс',
                'content'=>function($data){
                    return $data->sourse->name;
                }
                
            ],
            [
                'attribute'=>'parse_key_id',
                'label' => 'Ключ',
                'content'=>function($data){
                    return $data->parseKey->key;
                }
                
            ],
            [
                'attribute'=>'status',
                'label' => 'Статус',
                'content'=>function($data){
                    return $data->statusName;
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
