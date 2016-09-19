<?php
use yii\helpers\Html;

echo Html::beginTag('ul',['class' => 'list-unstyled']);
					echo Html::beginTag('li',['class' => 'title-smi']);
						if ($item->smi !== null) {
							echo Html::tag('span',$item->smi->name,['class' => 'label label-info']);
						}else{
							echo Html::tag('span','Нет в списке',['class' => 'label label-danger']);
						}
					echo Html::endTag('li');
					echo Html::beginTag('li',['class' => 'title-news']);
						echo Html::tag('h4',$item->title);
					echo Html::endTag('li');
					echo Html::beginTag('li',['class' => 'time-news']);
						
						echo Html::tag('span',date("d/m/y H:i",$item->time),['class' => 'label label-default']);
					echo Html::endTag('li');
					echo Html::beginTag('li',['class' => 'full-text-news']);
						if ($item->newsFullText !== null) {
							echo $item->newsFullText->text;
						}
					echo Html::endTag('li');
				echo Html::endTag('ul');
				echo Html::beginTag('hr');

?>