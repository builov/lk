<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Files;

/**
 * FilesSearch represents the model behind the search form of `common\models\Files`.
 */
class FilesSearch extends Files
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'sizex', 'sizey', 'weight', 'created'], 'integer'],
            [['path', 'name', 'mime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Files::find();

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
            'uid' => $this->uid,
            'sizex' => $this->sizex,
            'sizey' => $this->sizey,
            'weight' => $this->weight,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mime', $this->mime]);

        return $dataProvider;
    }
}
