<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParseKeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ключи для парсинга';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parse-key-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            
            [
                'attribute'=>'key',
                'label' => 'Ключи',
            ],
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
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
