<?php
use yii\helpers\Html;

if (empty($names)) {
	echo 'Ничего не найдено';
}else{
	foreach ($names as $key => $name) {
		echo Html::beginTag('div',['class' => 'row']);
			echo Html::beginTag('div',['class' => 'col-sm-3']);
				if (empty($photos[$key]) === false) {
					echo Html::img($photos[$key]);
				}
				
			echo Html::endTag('div');
			echo Html::beginTag('div',['class' => 'col-sm-9']);
				echo Html::tag('h4',$name);
				echo Html::beginTag('div',['class' => 'note']);
					echo (empty($notes[$key]) === false) ? $notes[$key] : 'Нет';
				echo Html::endTag('div');
			echo Html::endTag('div');
		echo Html::endTag('div');
		echo Html::beginTag('hr');
	}
}


 ?>