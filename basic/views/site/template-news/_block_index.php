<?php
use yii\helpers\Html;

echo Html::beginTag('div',['class' => 'row']);
	echo Html::beginTag('form',['name' => 'create-news']);
		echo Html::beginTag('div',['class' => 'col-sm-12']);
			echo Html::label('Заголовок', 'title');
			echo Html::textarea('title', '', ['class' => 'form-control']);
		echo Html::endTag('div');
		echo Html::beginTag('div',['class' => 'col-sm-12']);
			echo Html::label('Анонс', 'preview');
			echo Html::textarea('preview', '', ['class' => 'form-control']);
		echo Html::endTag('div');

		echo Html::beginTag('div',['class' => 'col-sm-12']);
			echo Html::label('Текст новости', 'text');
			echo Html::textarea('text', '', ['class' => 'form-control']);
		echo Html::endTag('div');
		echo Html::beginTag('div',['class' => 'col-sm-12','name' => 'block-result']);
			
		echo Html::endTag('div');
		echo Html::beginTag('div',['class' => 'col-sm-12 text-right div-submit']);
			echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary btn-sm']);
		echo Html::endTag('div');
	echo Html::endTag('form');
echo Html::endTag('div');
?>