<?php 
use yii\helpers\Html;

if (empty($news) === false) {
	echo Html::beginTag('div',['class' => 'block-list-peview-rss']);
	foreach ($news as $item) {
		echo Html::beginTag('ul',['class' => 'list-unstyled', 'name' => 'single-news']);
			echo Html::beginTag('li',['class' => 'title-sourse']);
				echo Html::tag('span',$item->sourse->name,['class' => 'label label-info']);
			echo Html::endTag('li');
			echo Html::beginTag('li',['class' => 'title-news','news' => $item->id]);
				echo Html::tag('h4',$item->title);
			echo Html::endTag('li');
			echo Html::beginTag('li',['class' => 'time-news']);
				echo Html::tag('span',date("d/m/y H:i",$item->time),['class' => 'label label-default']);
			echo Html::endTag('li');
		echo Html::endTag('ul');
	echo Html::beginTag('hr');


	}
	echo Html::endTag('div');
	
}
?>