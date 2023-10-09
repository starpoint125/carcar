<?php
namespace common\services;
/**
* This is the template for generating CRUD service class of the specified model.
*/

use backend\models\search\OrderSearch;
use backend\models\form\Order;

class OrderService extends Service implements OrderServiceInterface{
    public function getSearchModel(array $options=[])
    {
         return new  OrderSearch();
    }

    public function getModel($id, array $options = [])
    {
        return Order::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new Order();
        $model->loadDefaultValues();
        return $model;
    }
}
