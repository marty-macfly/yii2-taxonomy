<?php

namespace macfly\taxonomy\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use macfly\taxonomy\models\Term;

/**
 * TermSearch represents the model behind the search form about `macfly\taxonomy\models\Term`.
 */
class TermSearch extends Term
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'taxonomy_id', 'parent_id', 'usage_count'], 'integer'],
            [['name', 'slug', 'created_at', 'updated_at'], 'safe'],
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
        $query = Term::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' =>
              [
               'pageSize' => 50
              ],
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
            'taxonomy_id' => $this->taxonomy_id,
            'parent_id' => $this->parent_id,
            'usage_count' => $this->usage_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
