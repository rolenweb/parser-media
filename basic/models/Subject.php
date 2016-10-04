<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;
/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property integer $resourse_id
 * @property integer $parse_key_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Subject extends \yii\db\ActiveRecord
{
    const STATUS_SPIDER = 1;
    const STATUS_CRAWLER = 2;
    const STATUS_PROCESSED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subject';
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
            [['resourse_id', 'parse_key_id', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'url' => 'Url',
            'resourse_id' => 'Resourse ID',
            'parse_key_id' => 'Parse Key ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSourse()
    {
        return $this->hasOne(Sourse::className(), ['id' => 'resourse_id']);
    }

    public function getNews()
    {
        return $this->hasMany(News::className(), ['subject_id' => 'id'])
            ->with(['smi','newsFullText']);
    }

    

    public function getFirstNews()
    {
        return $this->hasOne(News::className(), ['subject_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('subject_category', ['subject_id' => 'id']);
    }

    public function titleSmi($format = 'arr')
    {
        $out = [];
        $news = $this->news;
        if (empty($news) === false) {
            foreach ($news as $item) {
                if ($item->smi !== null) {
                    $out[] = $item->smi->name;
                }
            }
        }

        if ($format === 'arr') {
            return array_unique($out);
        }else{
            return $this->formatListNameSmi(array_unique($out));
        }   
        
    }

    public function formatListNameSmi($list)
    {
        $out = '';
        if (empty($list) === false) {
            foreach ($list as $key => $item) {
                if ($key == 0) {
                    $out = Html::tag('span',$item,['class' => 'label label-info']);
                }else{
                    $out .= ', '.Html::tag('span',$item,['class' => 'label label-info']);
                }
            }
        }
        return $out;
    }

    /**
    Функция count_combinations(). Автор: valyala (valyala@tut.by)
    Подсчитывает количество повторений цепочек слов в массиве.
    Параметры:
        $words - массив подряд идущих слов, для которых нужно подсчитать количество повторений
        $chain_length - длина цепочки, для которой ведется подсчет
    Возвращает ассоциативный массив вида [ комбинация => счетчик ]
    */
    public function count_combinations($words, $chain_length) {
        $delimiter = ' '; // разделитель слов, использующийся в индексе
        $tmp = array(); // массив счетчиков различных комбинаций
        $n = sizeof($words) - $chain_length + 1; // количество итераций цикла while
        $i = 0;
        while ($i < $n) {
            $index = implode($delimiter, array_slice($words, $i, $chain_length)); // текущая цепочка слов длиной $chain_length
            if (!isset($tmp[$index])) $tmp[$index] = 1; // комбинация встретилась впервые
            else $tmp[$index]++; // комбинация уже встречалась
            $i++;
        }
        return $tmp;
    }

    public function phraseStats()
    {
        $out = [];
        $text = '';
        $list_news = $this->news;    
        if (empty($list_news) === false) {
            foreach ($list_news as $news) {
                if (empty($news->newsFullText) === false) {
                    $text .= ' '.str_replace($this->black(), '',  strip_tags($news->newsFullText->text));
                    
                }
            }

            if (empty(trim($text)) === false) {
                //$text = iconv("utf-8", "windows-1251", $text);
                $words = $this->deleleElementFromArray(explode(' ',$text),3);
                //var_dump(mb_detect_encoding($text));
                //die;
                $exact_match = $this->filerN($this->count_combinations($words, 3),2);
                
                if (empty($exact_match) !== false) {
                    $exact_match = $this->filerN($this->count_combinations($this->deleleElementFromArray(explode(' ',$text),3), 2),2);
                }
                arsort($exact_match);
                $out['exact_match'] = $exact_match;
            }
        }

        return $out;
    }

    public function deleleElementFromArray($in,$length)
    {
        $out = [];
        if (empty($in) === false) {
            foreach ($in as $item) {
                if (strlen($item) > $length && in_array($item,$this->stopWords()) === false) {
                    $out[] = mb_strtolower($item,'UTF-8');
                }
            }
        }
        
        return $out;
    }

    public function filerN($arr,$n = 2)
    {
        $out = [];
        if (empty($arr) === false) {
            foreach ($arr as $key => $value) {
                if ($value >= $n) {
                    $out[$key] = $value;
                }
            }
        }
        return $out;
    }

    public function black()
    {
        return [
            '\r\n',
            '\r',
            '\n',
            '.',
            ',',
            '?',
            '!',
            "\"",
            '(',
            ')',
            '/',
            '/',
            ':',
            ';',
            '[',
            ']',
            '«',
            '»',
        ];
    }
    public function stopWords()
    {
        return [
            
            'кроме',
            'того',
            'из',
            'об',
            'этом',
            'уже',
            'пока',
            'что',
            'такая',
            'по',
            'для',
            'или',
            'от',
            'по',
            'чтобы',
            'мы',
            'как',
            'его',
            'во',
            'всех',

        ];
    }
}
