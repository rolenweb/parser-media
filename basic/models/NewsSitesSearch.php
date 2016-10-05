<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NewsSites;

/**
 * NewsSitesSearch represents the model behind the search form about `app\models\NewsSites`.
 */
class NewsSitesSearch extends NewsSites
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'federal', 'region', 'rubric', 'type', 'CY', 'region2', 'comment'], 'integer'],
            [['name', 'url', 'email', 'adres', 'telephone', 'manager', 'MLG', 'uri', 'site', 'alexa_gk'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NewsSites::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'federal' => $this->federal,
            'region' => $this->region,
            'rubric' => $this->rubric,
            'type' => $this->type,
            'CY' => $this->CY,
            'region2' => $this->region2,
            'comment' => $this->comment,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'adres', $this->adres])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'manager', $this->manager])
            ->andFilterWhere(['like', 'MLG', $this->MLG])
            ->andFilterWhere(['like', 'uri', $this->uri])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'alexa_gk', $this->alexa_gk]);

        return $dataProvider;
    }
}
