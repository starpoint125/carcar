<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegistUsers;

/**
 * RegistUsersSearch represents the model behind the search form about `common\models\RegistUsers`.
 */
class RegistUsersSearch extends RegistUsers implements \backend\models\search\SearchInterface
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'phone', 'address', 'created_at','remark'], 'safe'],
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
        $query = RegistUsers::find();

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
        if (!empty($params['RegistUsersSearch']['created_at'])) {
            $time = explode('~',$params['RegistUsersSearch']['created_at']);
            $begin = trim($time[0]);
            $end = trim($time[1]);
            $query->andFilterWhere(['>=', 'created_at', strtotime($begin)])
                ->andFilterWhere(['<=', 'created_at', strtotime($end)]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'remark', $this->remark]);
        // echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }
}
