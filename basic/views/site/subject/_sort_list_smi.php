<?php
use yii\helpers\html;

echo Html::beginTag('div',['class' => 'col-xs-12']);
echo Html::beginTag('form',['class' => 'form-horizontal']);
	echo Html::beginTag('div',['class' => 'form-group']);
		echo Html::label('Ключевые слова', 'keyword', ['class' => 'col-sm-3 control-label']);
		echo Html::beginTag('div',['class' => 'col-sm-9']);
			echo Html::input('text', 'keyword', '', ['class' => 'form-control']);
		echo Html::endTag('div');
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'form-group']);
		echo Html::label('Организации', 'keyword', ['class' => 'col-sm-3 control-label']);
		echo Html::beginTag('div',['class' => 'col-sm-9']);
			echo Html::input('text', 'organisation', '', ['class' => 'form-control']);
		echo Html::endTag('div');
	echo Html::endTag('div');
	echo Html::beginTag('div',['class' => 'form-group']);
		echo Html::label('Люди', 'keyword', ['class' => 'col-sm-3 control-label']);
		echo Html::beginTag('div',['class' => 'col-sm-9']);
			echo Html::input('text', 'people', '', ['class' => 'form-control']);
		echo Html::endTag('div');
	echo Html::endTag('div');
echo Html::endTag('form');
echo Html::endTag('div');
?>
