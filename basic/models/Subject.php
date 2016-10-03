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
}
