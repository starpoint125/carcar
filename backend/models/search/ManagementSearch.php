<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\form\Management;

/**
 * ManagementSearch represents the model behind the search form about `backend\models\form\Management`.
 */
class ManagementSearch extends Management implements \backend\models\search\SearchInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cartype_id', 'type', 'seat_num', 'door_num', 'gear_position', 'status', 'recommend', 'created_at', 'updated_at'], 'integer'],
            [['name', 'avatar','deposit','money'], 'safe'],
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
    public function search(array $params = [], array $options = [])
    {
        $query = Management::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
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
            'cartype_id' => $this->cartype_id,
            'type' => $this->type,
            'seat_num' => $this->seat_num,
            'door_num' => $this->door_num,
            'gear_position' => $this->gear_position,
            'status' => $this->status,
            'recommend' => $this->recommend,
            'money' => $this->money,
            'deposit' => $this->deposit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        return $dataProvider;
    }
}
