<?php
namespace common\services;
/**
* This is the template for generating CRUD service class of the specified model.
*/

use backend\models\search\CartypeSearch;
use backend\models\form\Cartype;

class CartypeService extends Service implements CartypeServiceInterface{

    public function getSearchModel(array $options=[])
    {
         return new  CartypeSearch();
    }

    public function getModel($id, array $options = [])
    {
        return Cartype::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new Cartype();
        $model->loadDefaultValues();
        return $model;
    }
}
