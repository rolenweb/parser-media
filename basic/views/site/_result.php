<?php
use yii\helpers\Html;
if ($error != NULL) {
	foreach ($error as $item) {
		echo Html::beginTag('div',['class' => 'alert alert-danger', 'role' => 'alert']);
			echo $item;
		echo Html::endTag('div');
	}
}
if ($info != NULL) {
	foreach ($info as $item) {
		echo Html::beginTag('div',['class' => 'alert alert-success', 'role' => 'alert']);
			echo $item;
		echo Html::endTag('div');
	}
}

?>