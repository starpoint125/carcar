<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2020-01-30 10:02
 */

namespace backend\models\form;


use Yii;
use yii\rbac\Role;

class RBACRoleForm extends \yii\base\Model
{
    public $name;

    public $description;

    public $sort;

    private $roles = [];

    private $permissions = [];


    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['roles', 'permissions'], 'default', 'value' => []],
            [['sort'],'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            "description" => Yii::t('app', 'Description'),
            "sort" => Yii::t('app', 'Sort'),
            "name" => Yii::t('app', 'Role'),
            "permissions" => Yii::t('app', 'Permissions'),
            "roles" => Yii::t('app', 'Role'),
        ];
    }

    public function getData()
    {
        return json_encode([
            'sort' => $this->sort,
        ]);
    }

    public function setPermissions($permissions)
    {
        empty($permissions) && $permissions = [];
        $item = current($permissions);
        if( is_object($item) ){
            $newPermissions= call_user_func(function()use($permissions){
                $newPermissions = [];
                foreach($permissions as $permission){
                    $newPermissions[] = $permission->name;
                }
                return $newPermissions;
            });
        }else {
            $permissions = array_flip($permissions);
            if (isset($permissions['0'])) {
                unset($permissions[0]);
            }
            $newPermissions = array_flip($permissions);
        }
        foreach ($newPermissions as $permission){
            $this->permissions[$permission] = $permission;
        }
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setRoles($roles)
    {
        empty($roles) && $roles = [];
        $item = current($roles);
        if( is_object($item) ){
            $this->roles = call_user_func(function()use($roles){
                $newRoles = [];
                foreach($roles as $role){
                    $newRoles[] = $role->name;
                }
                return $newRoles;
            });
        }else {
            $roles = array_flip($roles);
            if (isset($roles['0'])) {
                unset($roles[0]);
            }
            $roles = array_flip($roles);
            $this->roles = $roles;
        }
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if( $values instanceof Role){
            $this->name = $values->name;
            $this->description = $values->description;
            $data = json_decode($values->data, true);
            $this->sort = $data['sort'];
        }else{
            parent::setAttributes($values, $safeOnly);
        }
    }
}