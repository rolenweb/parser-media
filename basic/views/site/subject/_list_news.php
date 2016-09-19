<?php 
use yii\helpers\Html;

if (empty($news) === false) {
		foreach ($news as $item) {
			if ($item->newsFullText !== null) {
				echo $this->render('_list_news_item.php',[
					'item' => $item,
				]);
			}


			
		}

		foreach ($news as $item) {
			if ($item->newsFullText === null) {
				echo $this->render('_list_news_item.php',[
					'item' => $item,
				]);
			}

			
			
		}
	
}
?>