<?php
use yii\helpers\Html;

if (empty($rss) === false) {
	echo Html::beginTag('div',['class' => 'block-list-rss']);
		echo Html::beginTag('ul',['class' => 'list-unstyled']);
			foreach ($rss as $item) {
				echo Html::beginTag('li',['class' => 'li-rss','rss' => $item->id]);
					echo Html::tag('span',$item->name,['class' => 'name-rss']);
					echo Html::tag('span',count($item->crawlerNews),['class' => 'badge']);
				echo Html::endTag('li');
			}
		echo Html::endTag('ul');
	echo Html::endTag('div');
	
}
?>