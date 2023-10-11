<?php
namespace common\services;
/**
* This is the template for generating CRUD service class of the specified model.
*/

use backend\models\search\RegistUsersSearch;
use common\models\RegistUsers;

class RegistUsersService extends Service implements RegistUsersServiceInterface{
    public function getSearchModel(array $options=[])
    {
         return new  RegistUsersSearch();
    }

    public function getModel($id, array $options = [])
    {
        return RegistUsers::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new RegistUsers();
        $model->loadDefaultValues();
        return $model;
    }
}
