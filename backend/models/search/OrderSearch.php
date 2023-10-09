<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\form\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\form\Order`.
 */
class OrderSearch extends Order implements \backend\models\search\SearchInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'car_id', 'status', 'deposit_status', 'extraction_method', 'created_at'], 'integer'],
            [['order_number', 'reservation_time'], 'safe'],
            [['price', 'car_rental_fee', 'deposit', 'insurance_expenses', 'total_cost'], 'number'],
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
        $query = Order::find();

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
            'uid' => $this->uid,
            'car_id' => $this->car_id,
            'reservation_time' => $this->reservation_time,
            'price' => $this->price,
            'car_rental_fee' => $this->car_rental_fee,
            'deposit' => $this->deposit,
            'insurance_expenses' => $this->insurance_expenses,
            'total_cost' => $this->total_cost,
            'status' => $this->status,
            'deposit_status' => $this->deposit_status,
            'extraction_method' => $this->extraction_method,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number]);

        return $dataProvider;
    }
}
