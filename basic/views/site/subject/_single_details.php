<?php
use yii\helpers\Html;

echo Html::beginTag('div',['class' => 'row keywords-stats']);
	echo Html::beginTag('div',['class' => 'col-sm-12']);
		echo Html::beginTag('ul',['class' => 'list-unstyled']);
			if (empty($keywords_stats['exact_match']) === false) {
				foreach ($keywords_stats['exact_match'] as $key => $value) {
					echo Html::beginTag('li');
						echo Html::tag('span',$key,['class' => 'keywords-stats']).Html::tag('span',$value,['class' => 'badge']);
					echo Html::endTag('li');
				}
			}
		echo Html::endTag('ul');
	echo Html::endTag('div');
echo Html::endTag('div');
echo Html::beginTag('div',['class' => 'row list-smi']);
	echo $this->render('_list_news',[
			'news' => $subject->news,
			
		]);
echo Html::endTag('div');

?>