<?php
use yii\helpers\Html;

if (empty($subjects) === false) {
	echo Html::beginTag('div',['class' => 'block-list-subject']);
	foreach ($subjects as $subject) {
			if (empty($subject->news) === false) {
				echo Html::beginTag('div',['class' => 'row', 'name' => 'sigle-subject','subject' => $subject->id]);
					echo Html::beginTag('div',['class' => 'col-sm-12','name' => 'block-display-results']);
					echo Html::endTag('div');
					echo Html::beginTag('div',['class' => 'col-sm-12']);
						echo Html::tag('h4',$subject->title,['name' => 'title-silgle-subject']);
					echo Html::endTag('div');	
					if ($subject->firstNews != NULL) {
						echo Html::beginTag('div',['class' => 'col-sm-6']);
							echo Html::tag('span',date("d/m/y H:i",$subject->firstNews->time),['class' => 'label label-default']);
						echo Html::endTag('div');
						echo Html::beginTag('div',['class' => 'col-sm-6 text-right']);
							echo Html::button('Не обработан',['class' => 'btn btn-danger btn-xs', 'name' => 'processed-subject', 'subject' => $subject->id]);
						echo Html::endTag('div');

						echo Html::beginTag('div',['class' => 'col-sm-12']);
							//echo $subject->firstNews->preview;
						echo Html::endTag('div');	
					}
					

					echo Html::beginTag('div',['class' => 'col-sm-12']);
						//echo Html::beginTag('div',['class' => 'block-list-news']);
							echo Html::tag('span','СМИ('.Html::tag('span',count($subject->news),['class' => 'number']).'): ',['style' => 'font-size: 16px;']) ;
							echo $subject->titleSmi('list');
						//echo Html::endTag('span');
						
					echo Html::endTag('div');	
				echo Html::endTag('div');
				echo Html::beginTag('hr');
			}
			
		
	}
	echo Html::endTag('div');
}

?>