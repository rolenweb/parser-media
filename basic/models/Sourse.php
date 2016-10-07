<?php

namespace app\models;

use Yii;
use yii\helpers\Console;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;

use app\models\News;
use app\models\NewsFullText;
use app\models\CssSelector;
use app\models\NewsProperty;
use app\models\NewsSites;

use app\commands\tools\NewsParser;
use app\commands\tools\CurlClient;
/**
 * This is the model class for table "sourse".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Sourse extends \yii\db\ActiveRecord
{

    const TYPE_MEDIA = 1;
    const TYPE_RSS = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sourse';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            LogDateBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTypeName()
    {
        if ($this->type == self::TYPE_MEDIA) {
            return 'СМИ';
        }
        if ($this->type == self::TYPE_RSS) {
            return 'RSS';
        }
    }

    public function getStatusName()
    {
        if ($this->status == self::STATUS_ACTIVE) {
            return 'Активные';
        }
        if ($this->status == self::STATUS_PENDING) {
            return 'Пауза';
        }
    }

    public static function ddType()
    {
        return [
            self::TYPE_MEDIA => 'СМИ',
            self::TYPE_RSS => 'RSS',
        ];
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_ACTIVE => 'Активные',
            self::STATUS_PENDING => 'Паура',
        ];
    }

    public static function ddList()
    {
        return self::find()->where(['status' => self::STATUS_ACTIVE])->all();
    }

    public function getKeysParse()
    {
        return $this->hasMany(ParseKey::className(), ['sourse_id' => 'id'])
            ->where(['status' => ParseKey::STATUS_ACTIVE]);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['sourse_id' => 'id'])
            ->where(['status' => Category::STATUS_ACTIVE]);
    }

    public function getCrawlerNews()
    {
        return $this->hasMany(News::className(), ['resourse_id' => 'id'])
            ->where(['status' => News::STATUS_CRAWLER]);
    }

    public function urlParse($key = null)
    {
        $categories = $this->categories;
        $cat_url = '';
        $cat_array = [];
        $out_url = '';
        foreach ($categories as $category) {
            if ($category->value !== null) {
                $cat_url .= '&catnews='.trim($category->value);
                $cat_array[] = trim($category->value);
            }
        }
        if ($key !== null) {
            $out_url = 'https://news.yandex.ru/yandsearch?text='.urlencode(trim($key->key)).'&rpt=nnews2&grhow=clutop'.$cat_url.'&within=7&from_day=&from_month=&from_year=&to_day=&to_month=&to_year=&numdoc=30';
            
        }else{
            $out_url = 'https://news.yandex.ru/yandsearch?text=&rpt=nnews2&grhow=clutop'.$cat_url.'&within=7&from_day=&from_month=&from_year=&to_day=&to_month=&to_year=&numdoc=30';
        }
        $this->saveCache($out_url,$cat_array,$key);
        return $out_url;
    }

    public function paramsUrlArray($url,$cat,$keyword)
    {
        $out = [];
        if (isset(parse_url($url)['query'])) {
            $params = parse_url($url)['query'];
            $arr1 = explode('&',$params);
            $n = 0;
            if (empty($arr1) === false) {
                foreach ($arr1 as $value) {
                    $arr2 = explode('=',$value);
                    if (empty($arr2) === false) {
                        if ($arr2[0] === 'catnews') {
                                                           
                        }else{
                            $out[$n][$arr2[0]] = $arr2[1];    
                            
                        }
                        $n++;    
                        
                    }
                }
                $out[]['catnews'] = $cat;  
                if ($keyword !== null) {
                    $out[]['keyword'] = $keyword->id;  
                }
            }else{

            }
        }
        return $out;
    }

    
    
    public function saveCache($url,$cat,$keyword)
    {
        $key = 'sourse_'.$this->id;
        $cache = Yii::$app->cache;
        if ($cache->exists($key)) {
            $cache->delete($key);
        }
        $cache->set($key,$this->paramsUrlArray($url,$cat,$keyword));
        
        return;
    }

    public function fullTextParseYandex()
    {
         $news = News::find()
            ->joinWith(['subject.sourse'])
            ->where([
                    'and',
                        [
                            'sourse.name' => 'yandex' 
                        ],
                        [
                            'news.status' => News::STATUS_SPIDER,
                        ],
                        $this->listRequestYandexFullText,
                ])
            ->all();//->createCommand()->sql;
        if (empty($news) === true) {
            return 'There are not news for parsing';
        }

        $parser = new NewsParser();
        foreach ($news as $item) {
            $this->success('Parse full text: '.$item->url);
            if ($item->url !== null) {
                $content = $parser->parsePage($item->url);
                if ($content !== null) {
                    $new_text = new NewsFullText();
                    $new_text->text = $content;
                    $new_text->news_id = $item->id;
                    $new_text->save();

                }
            }
            $item->status = $item::STATUS_CRAWLER;
            $item->save();
        }    
    }

    public function fullTextParseYandex2()
    {
         $news = News::find()
            ->joinWith(['smi.cssSeletors','subject.sourse'])
            ->where([
                    'and',
                        [
                            'sourse.name' => 'yandex' 
                        ],
                        [
                            'news_sites.fulltext' => NewsSites::FULLTEXT_YES,
                        ],
                        [
                            'news.status' => News::STATUS_SPIDER,
                        ],
                        
                ])
            ->all();//createCommand()->params;//->sql;
        
        if (empty($news) === true) {
            $this->error('There are not news for parsing');
            return;
        }

        foreach ($news as $item) {
            if ($item->url === null) {
                $this->error('The URL of news is null');
                return;
            }
            $this->success('Parse full text: '.$item->url);
            $client = new CurlClient();
            $content = $client->parsePage($item->url);
            $properties = $item->smi->cssSeletors;
            
            if (empty($properties) === false) {
                foreach ($properties as $property) {
                    if ($item->title === null && $property->name === CssSelector::NAME_TITLE) {
                        $title = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        $item->title = $title[0];
                    }
                    if ($item->newsFullText === null && $property->name === CssSelector::NAME_DESCRIPTION) {
                        $description = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        if (empty($description) === false) {
                            $new_text = new NewsFullText();
                            $new_text->text = $this->sumFullText($description);
                            $new_text->news_id = $item->id;
                            $new_text->save();
                        }
                        
                    }
                    if ($property->name !== CssSelector::NAME_TITLE && $property->name !== CssSelector::NAME_DESCRIPTION) {
                        $others = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        if (empty($others) === false) {
                            foreach ($others as $other) {
                                $new_prop = new NewsProperty();
                                $new_prop->news_id = $item->id;
                                $new_prop->css_selector_id = $property->id;
                                $new_prop->value = $other;
                                $new_prop->save();
                            }
                        }
                    }

                }
                $item->status = $item::STATUS_CRAWLER;
                $item->save();
            }
        }
    }

    public function getListRequestYandexFullText()
    {
        return [    
                    'or',
                                [
                                    'like','news.url','gazeta.ru',
                                ],
                                [
                                    'like','news.url','vedomosti.ru',
                                ],
                                [
                                    'like','news.url','rns.online',
                                ],
                                [
                                    'like','news.url','izvestia.ru',
                                ],
                                [
                                    'like','news.url','kommersant.ru',
                                ],
                                [
                                    'like','news.url','cnews.ru',
                                ],
                                [
                                    'like','news.url','rbc.ru',
                                ],
                                [
                                    'like','news.url','therunet.com',
                                ],
                                [
                                    'like','news.url','ria.ru',
                                ],
                                [
                                    'like','news.url','tass.ru',
                                ],
                                [
                                    'like','news.url','lenta.ru',
                                ],
                                [
                                    'like','news.url','ura.ru',
                                ],
                                [
                                    'like','news.url','securitylab.ru',
                                ],
                                [
                                    'like','news.url','regnum.ru',
                                ],
                                [
                                    'like','news.url','rusnovosti.ru',
                                ],
                                [
                                    'like','news.url','vc.ru',
                                ],
                                [
                                    'like','news.url','sostav.ru',
                                ],
                                [
                                    'like','news.url','adindex.ru',
                                ],
                                [
                                    'like','news.url','3dnews.ru',
                                ],
                                [
                                    'like','news.url','bfm.ru',
                                ]
        ];
    }

    public function parseProperties()
    {
        $news = News::find()
            ->joinWith(['smi.cssSeletors','newsFullText','sourse'])
            ->where([
                    'and',
                        [
                            'sourse.type' => self::TYPE_RSS
                        ],
                        [
                            'news.status' => News::STATUS_SPIDER,
                        ],
                        
                ])
            ->all();
        if (empty($news) !== false) {
            $this->error('There are not news for parsing');
            return;
        }
        foreach ($news as $item) {
            if ($item->url === null) {
                $this->error('The URL of news is null');
                return;
            }
            $client = new CurlClient();
            $content = $client->parsePage($item->url);
            $properties = $item->smi->cssSeletors;
            
            if (empty($properties) === false) {
                foreach ($properties as $property) {
                    if ($item->title === null && $property->name === CssSelector::NAME_TITLE) {
                        $title = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        $item->title = $title[0];
                    }
                    if ($item->newsFullText === null && $property->name === CssSelector::NAME_DESCRIPTION) {
                        $description = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        if (empty($description[0]) === false) {
                            $new_text = new NewsFullText();
                            $new_text->text = $description[0];
                            $new_text->news_id = $item->id;
                            $new_text->save();
                        }
                        
                    }
                    if ($property->name !== CssSelector::NAME_TITLE && $property->name !== CssSelector::NAME_DESCRIPTION) {
                        $others = $client->parseProperty($content,$property->type,$property->selector,$item->url,$property->attr);
                        if (empty($others) === false) {
                            foreach ($others as $other) {
                                $new_prop = new NewsProperty();
                                $new_prop->news_id = $item->id;
                                $new_prop->css_selector_id = $property->id;
                                $new_prop->value = $other;
                                $new_prop->save();
                            }
                        }
                    }

                }
                $item->status = $item::STATUS_CRAWLER;
                $item->save();
            }
        }
    }

    protected static function success($message)
    {
        Console::output(Console::ansiFormat($message, [Console::FG_GREEN]));
    }

    protected static function error($message)
    {
        Console::output(Console::ansiFormat($message, [Console::FG_RED]));
    }

    public function getCssSeletors($index = null)
    {
        if ($index !== null) {
            return $this->hasMany(CssSelector::className(), ['sourse_id' => 'id'])->indexBy($index);
        }
        return $this->hasMany(CssSelector::className(), ['sourse_id' => 'id']);
        
    }

    public function sumFullText($description)
    {
        $out = '';
        if (empty($description) === false) {
            foreach ($description as $item) {
                $out .= '<p>'.$item.'</p>';
            }
        }
        return $out;
    }

}
