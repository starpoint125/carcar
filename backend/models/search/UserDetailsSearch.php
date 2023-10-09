<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\form\UserDetails;

/**
 * UserDetailsSearch represents the model behind the search form about `backend\models\form\UserDetails`.
 */
class UserDetailsSearch extends UserDetails implements \backend\models\search\SearchInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'car_management_id', 'created_at', 'updated_at'], 'integer'],
            [['date', 'remark'], 'safe'],
            [['income', 'expenses'], 'number'],
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
        $query = UserDetails::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        //userid是否存在
        $userid = isset($params['userid']) ? $params['userid'] : null;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'car_management_id' => $this->car_management_id,
            'date' => $this->date,
            'income' => $this->income,
            'expenses' => $this->expenses,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'remark', $this->remark]);
        // 如果 $userid 存在，则添加查询条件
        if ($userid !== null) {
            $query->andFilterWhere(['userid' => $userid]);
        }
        return $dataProvider;
    }
}
