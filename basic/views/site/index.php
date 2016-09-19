<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Parser Media';
$this->registerJsFile('//cdn.tinymce.com/4/tinymce.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

echo Html::beginTag('div',['class' => 'row']);
    echo Html::beginTag('div',['class' => 'col-sm-12']);
        echo Html::beginTag('div',['class' => 'table-responsive']);
            echo Html::beginTag('table',['class' => 'table table-bordered']);
                echo Html::beginTag('col',['width' => '330', 'valign' => 'top']);
                echo Html::beginTag('col',['width' => '500', 'valign' => 'top']);
                echo Html::beginTag('thead');
                    echo Html::beginTag('tr');
                        echo Html::beginTag('th');
                            echo Html::beginTag('ul',['class' => 'list-inline']);
                                echo Html::beginTag('li');
                                    echo Html::beginTag('span');
                                        echo 'РУС(3)';
                                    echo Html::endTag('span');
                                echo Html::endTag('li');
                                echo Html::beginTag('li');
                                    echo Html::beginTag('span');
                                        echo 'ENG(3)';
                                    echo Html::endTag('span');
                                echo Html::endTag('li');
                                echo Html::beginTag('li');
                                    echo Html::beginTag('span');
                                        echo 'ПАРТНЕРЫ(3)';
                                    echo Html::endTag('span');
                                echo Html::endTag('li');
                            echo Html::endTag('ul');
                        echo Html::endTag('th');
                        echo Html::beginTag('th',['colspan' => 2, 'name' => 'title-subject']);
                            echo Html::tag('h4','Название сюжета');
                        echo Html::endTag('th');

                    echo Html::endTag('tr');
                echo Html::endTag('thead');
                echo Html::beginTag('tbody');
                    echo Html::beginTag('tr');
                        echo Html::beginTag('td');
                            echo $this->render('subject/_list',[
                                'subjects' => $subjects,
                                ]);
                        echo Html::endTag('td');
                        echo Html::beginTag('td');
                            echo Html::beginTag('div',['class' => 'pult-details-subject']);
                                echo $this->render('subject/_pult_details_subject');
                            echo Html::endTag('div');
                            echo Html::beginTag('div',['name' => 'block-details-subject', 'class' => 'block-details-subject']);
                                
                            echo Html::endTag('div');
                        echo Html::endTag('td');
                        echo Html::beginTag('td');
                            echo Html::beginTag('div',['name' => 'block-template-news', 'class' => 'block-template-news']);
                                echo $this->render('template-news/_block_index');
                                
                            echo Html::endTag('div');
                        echo Html::endTag('td');
                    echo Html::endTag('tr');
                echo Html::endTag('tbody');
            echo Html::endTag('table');
        echo Html::endTag('div');
    echo Html::endTag('div');
echo Html::endTag('div');
?>
