<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSitesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новостные сайты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-sites-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'url:url',
            'email:email',
            'adres',
            'telephone',
            'manager',
            'federal',
            // 'region',
            // 'rubric',
            // 'type',
            // 'CY',
            // 'MLG',
            // 'uri',
            // 'region2',
            // 'site',
            // 'alexa_gk',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p class="text-right">
        <?= Html::a('Добавить новостной сайт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
