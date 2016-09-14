<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

echo Html::beginTag('div',['class' => 'row']);
	echo Html::beginTag('div',['class' => 'col-sm-12']);
		echo Html::beginTag('div',['class' => 'table-responsive']);
            echo Html::beginTag('table',['class' => 'table table-bordered']);
                echo Html::beginTag('thead');
                    echo Html::beginTag('tr');
                        echo Html::beginTag('th');
                            echo 'Название';
                        echo Html::endTag('th');
                        echo Html::beginTag('th');
                            echo 'Url';
                        echo Html::endTag('th');
                        echo Html::beginTag('th');
                            echo 'Тип';
                        echo Html::endTag('th');
                        echo Html::beginTag('th');
                            echo 'Статус';
                        echo Html::endTag('th');
                    echo Html::endTag('tr');
                echo Html::endTag('thead');
                echo Html::beginTag('tbody');
                	if ($sourses != NULL) {
						foreach ($sourses as $item) {
			        		echo Html::beginTag('tr');
		                        echo Html::beginTag('td');
		                            echo $item->name;
		                        echo Html::endTag('td');
		                        echo Html::beginTag('td');
		                            echo $item->url;
		                        echo Html::endTag('td');
		                        echo Html::beginTag('td');
		                            echo $item->typeName;
		                        echo Html::endTag('td');
		                        echo Html::beginTag('td');
		                            echo $item->statusName;
		                        echo Html::endTag('td');
		                    echo Html::endTag('tr');    
			        	}
					}
                    
                echo Html::endTag('tbody');
            echo Html::endTag('table');
        echo Html::endTag('div');
		
	echo Html::endTag('div');	
echo Html::endTag('div');

echo Html::beginTag('div',['class' => 'row']);
	echo Html::beginTag('div',['class' => 'col-sm-6']);
		$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
			echo $form->field($sourse, 'name')->textInput(['maxlength' => true]);
			echo $form->field($sourse, 'url')->textInput(['maxlength' => true]);
			echo $form->field($sourse, 'type')->dropDownList([
					1 => 'СМИ',
					2 => 'RSS',
				])->label('Тип');
			echo Html::beginTag('div',['class' => 'form-group']);
				echo Html::submitButton('Создать', ['class' => 'btn btn-success']);
			echo Html::endTag('div');
		ActiveForm::end();
	echo Html::endTag('div');	
echo Html::endTag('div');
?>
