<?php
namespace common\services;
/**
* This is the template for generating CRUD service class of the specified model.
*/

use backend\models\search\UserDetailsSearch;
use backend\models\form\UserDetails;

class UserDetailsService extends Service implements UserDetailsServiceInterface{
    public function getSearchModel(array $options=[])
    {
         return new  UserDetailsSearch();
    }

    public function getModel($id, array $options = [])
    {
        return UserDetails::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new UserDetails();
        $model->loadDefaultValues();
        return $model;
    }
}
