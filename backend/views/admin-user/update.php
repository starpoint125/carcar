<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-31 17:07
 */
use yii\helpers\Url;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Admin Users'), 'url' => Url::to(['index'])],
    ['label' => Yii::t('app', 'Update') . Yii::t('app', 'Admin Users')],
];
/**
 * @var $model common\models\AdminUser
 * @var $assignModel backend\models\form\AssignPermissionForm
 * @var $permissions []
 * @var $roles []
 */
?>
<?php
if (Yii::$app->controller->action->id == 'update') {
    echo $this->render('_form', [
        'model' => $model,
        'assignModel' => $assignModel,
        'permissions' => $permissions,
        'roles' => $roles,
    ]);
} else {
    echo $this->render('_form-update-self', [
        'model' => $model,
    ]);
}
?>
