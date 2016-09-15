<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preview'], 'string'],
            [['description_id', 'resourse_id', 'parse_key_id', 'status', 'created_at', 'updated_at'], 'integer'],
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

    public function getParseKey()
    {
        return $this->hasOne(ParseKey::className(), ['id' => 'parse_key_id']);
    }

    public function getDescription()
    {
        return $this->hasOne(Description::className(), ['id' => 'description_id']);
    }
}
