<?php 
use yii\helpers\Html;

if (empty($news) === false) {
		foreach ($news as $item) {
			echo Html::beginTag('ul',['class' => 'list-unstyled']);
				echo Html::beginTag('li',['class' => 'title-smi']);
					if ($item->smi !== null) {
						echo $item->smi->name;
					}else{
						echo 'Нет в списке';
					}
				echo Html::endTag('li');
				echo Html::beginTag('li',['class' => 'title-news']);
					echo $item->title;
				echo Html::endTag('li');
				echo Html::beginTag('li',['class' => 'time-news']);
					echo date("d/m/y H:i",$item->time);
				echo Html::endTag('li');
				echo Html::beginTag('li',['class' => 'full-text-news']);
					if ($item->newsFullText !== null) {
						echo $item->newsFullText->text;
					}
				echo Html::endTag('li');
			echo Html::endTag('ul');
			echo Html::beginTag('hr');
		}
	
}
?>