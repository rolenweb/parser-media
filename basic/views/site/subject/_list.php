<?php
use yii\helpers\Html;

if (empty($subjects) === false) {
	foreach ($subjects as $subject) {
		echo Html::beginTag('div',['class' => 'row']);
			echo Html::beginTag('div',['class' => 'col-sm-12']);
				echo Html::tag('h4',$subject->title);
			echo Html::endTag('div');	

			echo Html::beginTag('div',['class' => 'col-sm-12']);
				echo date("H:i",$subject->firstNews->time);
			echo Html::endTag('div');	

			echo Html::beginTag('div',['class' => 'col-sm-12']);
				echo $subject->firstNews->preview;
			echo Html::endTag('div');	

			echo Html::beginTag('div',['class' => 'col-sm-12']);
				echo 'СМИ('.count($subject->news).')';
			echo Html::endTag('div');	
		echo Html::endTag('div');
		echo Html::beginTag('hr');
	}
}
?>