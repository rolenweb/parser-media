<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii;
use yii\console\Controller;

use app\commands\tools\CurlClient;
use app\commands\tools\SymfonyParser;
use Symfony\Component\DomCrawler\Link;
use app\commands\tools\Recognize;

use app\models\Sourse;
use app\models\Setting;
use app\models\Subject;
use app\models\News;
use app\models\Category;
use app\models\SubjectCategory;
use app\models\NewsSites;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TestController extends BaseCommand
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {

        for ($i=0; $i < 100; $i++) { 
            echo 'start';
            sleep(5);
        }
    }



    

}