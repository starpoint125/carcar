<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-10-16 16:02
 */

namespace backend\models\search;

use Yii;
use common\models\FriendlyLink;
use common\libs\Constants;
use backend\behaviors\TimeSearchBehavior;
use backend\components\search\SearchEvent;
use yii\data\ActiveDataProvider;


class FriendlyLinkSearch extends FriendlyLink implements SearchInterface
{

    public function behaviors()
    {
        return [
            TimeSearchBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'string'],
            [['status', 'image'], 'integer'],
            [['created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * @param array $params
     * @param array $options
     * @return object|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search(array $params = [], array $options = [])
    {
        $query = FriendlyLink::find()->orderBy(['sort'=>SORT_ASC, 'id'=>SORT_DESC]);
        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'id' => SORT_DESC,
                ]
            ]
        ]);
        /** @var $dataProvider ActiveDataProvider */
        $this->load($params);
        if (! $this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['status' => $this->status])
            ->andFilterWhere(['like', 'url', $this->url]);
        if ($this->image == Constants::YesNo_Yes) {
            $query->andWhere(['<>', 'image', '']);
        } else {
            if ($this->image === '0') {
                $query->andWhere(['image' => '']);
            }
        }
        $this->trigger(SearchEvent::BEFORE_SEARCH, Yii::createObject(['class' => SearchEvent::className(), 'query'=>$query]));
        return $dataProvider;
    }

}