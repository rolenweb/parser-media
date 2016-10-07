<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\components\LogDateBehavior;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $preview
 * @property string $content
 * @property integer $sourse_id
 * @property integer $subject_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    const STATUS_SAVE = 1;
    const STATUS_POST = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
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
            [['preview', 'content'], 'string'],
            [['sourse_id', 'subject_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
            'content' => 'Content',
            'sourse_id' => 'Sourse ID',
            'subject_id' => 'Subject ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNameStatus()
    {
        if ($this->status === self::STATUS_SAVE) {
            return 'Сохранен';
        }
        if ($this->status === self::STATUS_POST) {
            return 'Опубликован';
        }
    }

    public static function ddStatus()
    {
        return [
            self::STATUS_SAVE => 'Сохранен',
            self::STATUS_POST => 'Опубликован',
        ];
    }
}
