<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ресурсы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sourse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                'attribute'=>'name',
                'label' => 'Название',
            ],
            'url:url',
            
            [
                'attribute'=>'type',
                'label' => 'Тип',
                'content'=>function($data){
                    return $data->typeName;
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
    <p class="text-right">
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
