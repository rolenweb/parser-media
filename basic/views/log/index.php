<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Log;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'object',
                'label' => 'Объект',
               
            ],
            
            [
                'attribute' => 'object_id',
                'label' => 'Объект ID',
               
            ],
            [
                'attribute'=>'type',
                'label' => 'Тип',
                'content'=>function($data){
                    if ($data->type == Log::CREATED) {
                        return 'created';
                    }
                    if ($data->type == Log::MODIFIED) {
                        return 'modified';
                    }
                }
                
            ],
            [
                'attribute'=>'data',
                'label' => 'Данные',
                'content'=>function($data){
                    return $data->displayData();
                }
                
            ],
            'created_at:datetime',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
