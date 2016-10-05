<?php
use yii\helpers\Html;
if (empty($error) === false) {
	foreach ($error as $item) {
		echo Html::beginTag('div',['class' => 'alert alert-danger', 'role' => 'alert']);
			echo $item;
		echo Html::endTag('div');
	}
}
if (empty($info) === false) {
	foreach ($info as $item) {
		echo Html::beginTag('div',['class' => 'alert alert-success', 'role' => 'alert']);
			echo $item;
		echo Html::endTag('div');
	}
}

?>