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
}
