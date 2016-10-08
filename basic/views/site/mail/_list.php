<?php
use yii\helpers\Html;

if (empty($mails) === false) {
	echo Html::beginTag('div',['class' => 'block-list-mail']);
		echo Html::beginTag('ul',['class' => 'list-unstyled']);
			foreach ($mails as $item) {
				echo Html::beginTag('li',['class' => 'li-mail','mail' => $item->id]);
					echo Html::tag('span',$item->name,['class' => 'name-mail']);
					echo Html::tag('span',count($item->crawlerNews),['class' => 'badge']);
				echo Html::endTag('li');
			}
		echo Html::endTag('ul');
	echo Html::endTag('div');
	
}
?>