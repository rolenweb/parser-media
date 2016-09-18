<?php
use yii\helpers\Html;

if (empty($subjects) === false) {
	echo Html::beginTag('div',['class' => 'block-list-subject']);
	foreach ($subjects as $subject) {
		
			echo Html::beginTag('div',['class' => 'row', 'name' => 'sigle-subject','subject' => $subject->id]);
				echo Html::beginTag('div',['class' => 'col-sm-12']);
					echo Html::tag('h4',$subject->title,['name' => 'title-silgle-subject']);
				echo Html::endTag('div');	
				if ($subject->firstNews != NULL) {
					echo Html::beginTag('div',['class' => 'col-sm-12']);
						echo date("H:i",$subject->firstNews->time);
					echo Html::endTag('div');	

					echo Html::beginTag('div',['class' => 'col-sm-12']);
						echo $subject->firstNews->preview;
					echo Html::endTag('div');	
				}
				

				echo Html::beginTag('div',['class' => 'col-sm-12']);
					echo 'СМИ('.count($subject->news).'): ';
					echo $subject->titleSmi('list');
				echo Html::endTag('div');	
			echo Html::endTag('div');
			echo Html::beginTag('hr');
		
	}
	echo Html::endTag('div');
}

?>