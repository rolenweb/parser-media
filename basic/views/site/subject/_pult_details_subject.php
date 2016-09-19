<?php
use yii\helpers\Html;
echo Html::beginTag('div',['class' => 'row row-title']);
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Новости('.Html::tag('span','',['class' => 'number']).')',['class' => 'title']);
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Спикеры()',['class' => 'title']);
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Wiki()',['class' => 'title']);
	echo Html::endTag('div');
echo Html::endTag('div');
echo Html::beginTag('div',['class' => 'row sort-list-smi']);
	echo $this->render('_sort_list_smi',[
			
		]);
	
echo Html::endTag('div');
echo Html::beginTag('hr');
?>