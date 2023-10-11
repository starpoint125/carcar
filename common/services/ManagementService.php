<?php
namespace common\services;
/**
* This is the template for generating CRUD service class of the specified model.
*/

use backend\models\search\ManagementSearch;
use backend\models\form\Management;

class ManagementService extends Service implements ManagementServiceInterface{
    public function getSearchModel(array $options=[])
    {
         return new  ManagementSearch();
    }

    public function getModel($id, array $options = [])
    {
        return Management::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new Management();
        $model->loadDefaultValues();
        return $model;
    }
     /**
     * @param int $limit
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRecentComments($limit = 10)
    {
        return $this->newModel()->find()->orderBy('created_at desc')->limit($limit)->all();
    }
    public function getCarCountByPeriod($startAt=null, $endAt=null)
    {
        $model = Management::find();
        if( $startAt != null && $endAt != null ){
            $model->andWhere(["between", "created_at", $startAt, $endAt]);
        }else if ($startAt != null){
            $model->andwhere([">", "created_at", $startAt]);
        } else if($endAt != null){
            $model->andWhere(["<", "created_at", $endAt]);
        }
        return $model->count('id');
    }
}
