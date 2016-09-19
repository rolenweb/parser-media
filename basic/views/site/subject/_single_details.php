<?php
use yii\helpers\Html;


echo Html::beginTag('div',['class' => 'row list-smi']);
	echo $this->render('_list_news',[
			'news' => $subject->news,
		]);
	
echo Html::endTag('div');

?>