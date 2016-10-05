<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;

use app\models\Subject;
/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $preview
 * @property string $url
 * @property integer $description_id
 * @property integer $resourse_id
 * @property integer $parse_key_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{

    const STATUS_SPIDER = 1;
    const STATUS_CRAWLER = 2;
    const STATUS_PROCESSED = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
            [['preview'], 'string'],
            [['description_id', 'resourse_id', 'parse_key_id', 'status', 'created_at', 'updated_at', 'subject_id','time', 'news_site_id'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'preview' => 'Preview',
            'url' => 'Url',
            'description_id' => 'Description ID',
            'resourse_id' => 'Resourse ID',
            'parse_key_id' => 'Parse Key ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getStatusName()
    {
        if ($this->status == self::STATUS_SPIDER) {
            return 'Превью';
        }
        if ($this->status == self::STATUS_CRAWLER) {
            return 'Полный текст';
        }
        if ($this->status == self::STATUS_PROCESSED) {
            return 'Обработана';
        }
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_SPIDER => 'Превью',
            self::STATUS_CRAWLER => 'Полный текс',
            self::STATUS_PROCESSED => 'Обработана',
        ];
    }

    public function getSourse()
    {
        return $this->hasOne(Sourse::className(), ['id' => 'resourse_id']);
    }

    public function getSmi()
    {
        return $this->hasOne(NewsSites::className(), ['id' => 'news_site_id']);
    }

    public function getParseKey()
    {
        return $this->hasOne(ParseKey::className(), ['id' => 'parse_key_id']);
    }

    public function getNewsFullText()
    {
        return $this->hasOne(NewsFullText::className(), ['news_id' => 'id']);
    }

    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    public function GetMarkingText()
    {
        if ($this->newsFullText === null) {
            return;
        }
        $content = $this->newsFullText->text;
        preg_match_all('~"(.*?)"~',$content,$matchs,PREG_SET_ORDER); 
        if (empty($matchs) === false) {
            $quotes = [];
            foreach ($matchs as $match) {
                if (empty($match[0]) === false) {
                    $quotes[] = $match[0];
                    
                }
            }
            if (empty($quotes) === false) {
                foreach (array_unique($quotes) as $quote) {
                    $content = str_replace($quote,Html::tag('span',$quote,['class' => 'quotes-in-text']),$content);
                }
            }
        }

        $words = explode(' ',$this->clearText);
        if (empty($words) === false) {
            $upwords = [];
            foreach ($words as $word) {
                if (mb_strtoupper($word,'UTF-8') === $word && strlen(trim($word)) > 2 && ctype_digit($word) === false) {
                    $upwords[] = $word;
                }
            }
            foreach (array_unique($upwords) as $upword) {
                $content = str_replace($upword,Html::tag('span',$upword,['class' => 'abbreviation-in-text']),$content);
            }

        }

        $words = explode(' ',$this->clearText);
        if (empty($words) === false) {
            $numbers = [];
            foreach ($words as $word) {
                if (is_numeric($word)) {
                    $numbers[] = $word;
                }
            }
            foreach (array_unique($numbers) as $number) {
                $content = str_replace($number,Html::tag('span',$number,['class' => 'number-in-text']),$content);
            }

        }

        return $content;
    }

    public function GetClearText()
    {
        return str_replace((new Subject())->black(), '',  strip_tags($this->newsFullText->text));
    }  
     
}
