<?php
use yii\helpers\Html;

echo Html::beginTag('div',['class' => 'row row-title']);
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Новости('.count($subject->news).')',['class' => 'title']);
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Спикеры()',['class' => 'title']);
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'col-xs-4']);
		echo Html::tag('span','Wiki()',['class' => 'title']);
	echo Html::endTag('div');
echo Html::endTag('div');

echo Html::beginTag('div',['class' => 'row list-smi']);
	echo $this->render('_list_news',[
			'news' => $subject->news,
		]);
	
echo Html::endTag('div');

?>