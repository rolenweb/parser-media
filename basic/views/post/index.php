<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

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
                'label' => 'Титле',
               
            ],
            [
                'attribute'=>'preview',
                'label' => 'Аннос',
               
            ],
            /*[
                'attribute'=>'content',
                'label' => 'Контент',
                'content'=>function($data){
                    return HtmlPurifier::process($data->content);
                }
               
            ],*/
            
            [
                'attribute'=>'status',
                'label' => 'Статус',
                'content'=>function($data){
                    return $data->nameStatus;
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
