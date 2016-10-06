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

use app\models\Sourse;
use app\models\CssSelector;
use app\models\News;
use app\models\NewsSites;






/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class RssParserController extends BaseCommand
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {

        for ($i=0; $i < 100000000; $i++) { 
            $this->success("Iteration: ".$i);
            $sourses = Sourse::find()->where(
                    [
                        'and',
                            ['type' => Sourse::TYPE_RSS],
                            ['status' => Sourse::STATUS_ACTIVE]            
                    ]
                )->all();
            if (empty($sourses)) {
                $this->error('Sourses not found');
                return;
            }
            $this->parse($sourses);            
            $this->success("Sleep: 30 мин.");    
            sleep(1800);
        }
        
    }

    public function parse($sourses)
    {
        if (empty($sourses)) {
            $this->error('Sourses not found');
            return;
        }
        foreach ($sourses as $sourse) {
            $this->success("parse url: ".$sourse->url);
            $this->parsePreview($sourse);
            $sourse->parseProperties();
        }
    }

    public function parsePreview($sourse)
    {
        $properties = $sourse->cssSeletors;
        if (empty($properties) === false) {
            $client = new CurlClient();
            $content = $client->parsePage($sourse->url);
            if (empty($content) === false) {
                foreach ($properties as $property) {
                    if (empty($property->name) === false) {
                        $property_value[$property->name] = $client->parseProperty($content,$property->type,$property->selector,$sourse->url,$property->attr);    
                    }else{
                        $this->error('Css selector NAME is null for sourse id: '.$sourse->id);
                    }
                }
                if (empty($property_value[CssSelector::NAME_URL]) === false && empty($property_value[CssSelector::NAME_TITLE]) === false) {
                    foreach ($property_value[CssSelector::NAME_URL] as $key => $value) {
                        $smid = $this->siteNews(trim($value));
                        if ($smid !== null) {
                            if (News::findOne(['url' => trim($value)]) === null) {
                                $news = new News();
                                $news->resourse_id = $sourse->id;
                                $news->url = trim($value);
                                $news->status = News::STATUS_SPIDER;
                                $news->news_site_id = $smid;
                                $news->title = (empty($property_value[CssSelector::NAME_TITLE][$key]) === false) ? $property_value[CssSelector::NAME_TITLE][$key] : null;
                                $news->time = (empty($property_value[CssSelector::NAME_DATE][$key]) === false) ? strtotime($property_value[CssSelector::NAME_DATE][$key]) : null;
                                if ($news->save()) {
                                    
                                }
                                else{
                                    $this->error('News '.$value.' is not saved for sourse id: '.$sourse->id);    
                                }
                            }else{
                                $this->success('Preview is already saved for sourse id: '.$sourse->id);
                            }
                        }else{
                            $this->error('News Site is not found for sourse id: '.$sourse->id);       
                        }
                    }
                }else{
                    $this->error('Array of URL or TITLE is null for sourse id: '.$sourse->id);    
                }

            }else{
                $this->error('Content is null for sourse id: '.$sourse->id);
            }
        }
    }

    public function siteNews($url)
    {
        $arr_url = parse_url($url);
        if (empty($arr_url['host']) === false) {
            $host = trim($arr_url['host']);
            $smi = NewsSites::find()->where(['like','url',$host])->limit(1)->one();
            if ($smi !== null) {
                return $smi->id;
            }
        }
        return;    
    }

 
}