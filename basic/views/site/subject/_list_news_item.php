<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

use app\models\Sourse;

echo Html::beginTag('ul',['class' => 'list-unstyled', 'name' => 'single-news']);
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
							//echo //$item->markingText;
							if ($item->sourse !== null) {
								if ($item->sourse->type === Sourse::TYPE_MAIL) {
									echo HtmlPurifier::process($item->newsFullText->text);
								}else{
									echo $item->markingText;	
								}
							}else{
								echo $item->markingText;
							}
							;
						}else{
							echo $item->preview;
						}
					echo Html::endTag('li');
					echo Html::beginTag('li',['class' => 'news-property']);
						$properties = $item->properties;
						if (empty($properties) === false) {
							echo Html::beginTag('ul',['class' => 'list-unstyled']);
								foreach ($properties as $property) {
									echo Html::beginTag('li');
										echo Html::tag('span',$property->cssSelector->name.':',['class' => 'name-property']);
										echo Html::tag('span',$property->value,['class' => 'value-property']);
									echo Html::endTag('li');
								}
							echo Html::endTag('ul');
						}
					echo Html::endTag('li');
					echo Html::beginTag('li',['name' => 'block-result']);

					echo Html::endTag('li');
					echo Html::beginTag('li',['class' => 'input-to-template text-right']);
						echo Html::a('Оригинал',$item->url,['class' => 'btn btn-warning btn-xs','target' => '_blank']);
						echo Html::button(($item->status === $item::STATUS_PROCESSED) ? 'Обработана' : 'Не обработана',['class' => ($item->status === $item::STATUS_PROCESSED) ? 'btn btn-default btn-xs' : 'btn btn-danger btn-xs','name' => 'btn-status-news','news' => $item->id]);
						if ($item->newsFullText !== null) {
							echo Html::button('Вставить',['class' => 'btn btn-primary btn-xs','name' => 'input-to-template']);
						}
						
					echo Html::endTag('li');
				echo Html::endTag('ul');
				echo Html::beginTag('hr');

?>