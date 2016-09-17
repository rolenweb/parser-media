<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news_sites".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $email
 * @property string $adres
 * @property string $telephone
 * @property string $manager
 * @property integer $federal
 * @property integer $region
 * @property integer $rubric
 * @property integer $type
 * @property integer $CY
 * @property string $MLG
 * @property string $uri
 * @property integer $region2
 * @property string $site
 * @property string $alexa_gk
 * @property integer $comment
 */
class NewsSites extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['federal', 'region', 'rubric', 'type', 'CY', 'region2', 'comment'], 'integer'],
            [['region2', 'site', 'alexa_gk'], 'required'],
            [['name', 'url', 'email', 'adres', 'telephone', 'manager', 'MLG', 'uri', 'site', 'alexa_gk'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'adres' => 'Adres',
            'telephone' => 'Telephone',
            'manager' => 'Manager',
            'federal' => 'Federal',
            'region' => 'Region',
            'rubric' => 'Rubric',
            'type' => 'Type',
            'CY' => 'Cy',
            'MLG' => 'Mlg',
            'uri' => 'Uri',
            'region2' => 'Region2',
            'site' => 'Site',
            'alexa_gk' => 'Alexa Gk',
            'comment' => 'Comment',
        ];
    }
}
