<?php
use yii\helpers\Html;
if (empty($property) === false) {
	echo Html::beginTag('ul',['class' => 'list-unstiled']);
		foreach ($property as $item) {
			echo Html::tag('li',$item);
		}	
	echo Html::endTag('ul');
	
}else{
	'Ничего не найдено, попробуйте поменять селектор';
}
?>