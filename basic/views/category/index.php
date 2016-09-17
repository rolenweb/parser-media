<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'label' => 'Название',
            ],
            [
                'attribute' => 'value',
                'label' => 'Значение',
            ],
            [
                'attribute' => 'sourse_id',
                'label' => 'Ресурс',
                'content'=>function($data){
                    if ($data->sourse !== NULL) {
                        return $data->sourse->name;
                    }
                    
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
