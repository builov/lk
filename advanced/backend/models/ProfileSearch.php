<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Profile;

/**
 * ProfileSearch represents the model behind the search form of `common\models\Profile`.
 */
class ProfileSearch extends Profile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'gender', 'education_level', 'graduate_year', 'region', 'zip', 'agree', 'created', 'updated', 'status'], 'integer'],
            [['lastname', 'firstname', 'patronim', 'birthdate', 'snils', 'institution', 'passport_series', 'passport_number', 'passport_issued', 'passport_code', 'passport_date', 'address_passport', 'address_current', 'phone', 'certificate_series', 'certificate_number'], 'safe'],
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
        $query = Profile::find();

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
            'uid' => $this->uid,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'education_level' => $this->education_level,
            'graduate_year' => $this->graduate_year,
            'passport_date' => $this->passport_date,
            'region' => $this->region,
            'zip' => $this->zip,
            'agree' => $this->agree,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'patronim', $this->patronim])
            ->andFilterWhere(['like', 'snils', $this->snils])
            ->andFilterWhere(['like', 'institution', $this->institution])
            ->andFilterWhere(['like', 'passport_series', $this->passport_series])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'passport_issued', $this->passport_issued])
            ->andFilterWhere(['like', 'passport_code', $this->passport_code])
            ->andFilterWhere(['like', 'address_passport', $this->address_passport])
            ->andFilterWhere(['like', 'address_current', $this->address_current])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'certificate_series', $this->certificate_series])
            ->andFilterWhere(['like', 'certificate_number', $this->certificate_number]);

        return $dataProvider;
    }
}
