<?php
use yii\helpers\Html;

echo Html::beginTag('div',['class' => 'modal fade', 'id' => 'speaker','tabindex' => '-1', 'role' => 'dialog','aria-labelledby' => 'Поиск спикеров']);
	echo Html::beginTag('div',['class' => 'modal-dialog', 'role' => 'document']);
		echo Html::beginTag('div',['class' => 'modal-content']);
			echo Html::beginTag('div',['class' => 'modal-header']);
				echo Html::button(Html::tag('span','&times;',['aria-hidden' => 'true']),['class' => 'close','data-dismiss' => 'modal','aria-label' => 'Close']);
				echo Html::tag('h4','Поиск спикеров',['class' => 'modal-title']);
			echo Html::endTag('div');
			echo Html::beginTag('div',['class' => 'modal-body']);
				echo Html::beginTag('div',['class' => 'row']);
					echo Html::beginTag('div',['class' => 'col-sm-12']);
						echo Html::beginTag('form',['class' => 'form-inline','name' => 'find-speaker']);
							echo Html::beginTag('div',['class' => 'form-group']);
								echo Html::input('text', 'name', '', ['class' => 'form-control','placeholder' => 'Имя']);
							echo Html::endTag('div');
							echo Html::submitButton('Найти', ['class' => 'btn btn-default']);
						echo Html::endTag('form');
					echo Html::endTag('div');
					echo Html::beginTag('div',['class' => 'col-sm-12','name' => 'block-result-search']);

					echo Html::endTag('div');
				echo Html::endTag('div');
			echo Html::endTag('div');
			
		echo Html::endTag('div');
	echo Html::endTag('div');

echo Html::endTag('div');
?>


