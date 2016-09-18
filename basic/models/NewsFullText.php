<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "news_full_text".
 *
 * @property integer $id
 * @property string $text
 * @property integer $news_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class NewsFullText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_full_text';
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
            [['text'], 'string'],
            [['news_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'news_id' => 'News ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
