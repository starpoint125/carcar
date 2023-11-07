<?php

namespace backend\controllers;

use Yii;
use common\services\RegistUsersServiceInterface;
use common\services\RegistUsersService;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\ViewAction;
use yii\web\Response;
use common\models\RegistUsers;
use common\models\User;
/**
 * RegistUsersController implements the CRUD actions for RegistUsers model.
 */
class RegistUsersController extends \yii\web\Controller
{
    /**
    * @auth
    * - item group=未分类 category=Regist Users description-get=列表 sort=000 method=get
    * - item group=未分类 category=Regist Users description=创建 sort-get=001 sort-post=002 method=get,post
    * - item group=未分类 category=Regist Users description=修改 sort=003 sort-post=004 method=get,post
    * - item group=未分类 category=Regist Users description-post=删除 sort=005 method=post
    * - item group=未分类 category=Regist Users description-post=排序 sort=006 method=post
    * - item group=未分类 category=Regist Users description-get=查看 sort=007 method=get
    * @return array
    */
    public function actions()
    {
        /** @var RegistUsersServiceInterface $service */
        $service = Yii::$app->get(RegistUsersServiceInterface::ServiceName);
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function($query) use($service){
                    $result = $service->getList($query);
                    $userid = Yii::$app->request->get('userid');
                    $bdcar = Yii::$app->request->get('bdcar');
                    return [
                        'dataProvider' => $result['dataProvider'],
                        'searchModel' => $result['searchModel'],                    
                        'userid' => $userid,                    
                        'bdcar' => $bdcar,                    
                    ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'doCreate' => function(array $postData) use($service){
                    return $service->create($postData);
                },
                'data' => function($createResultModel, $createAction) use($service){
                    $model = $createResultModel === null ? $service->newModel() : $createResultModel;
                    $userid = Yii::$app->request->get('userid');
                    $bdcar = Yii::$app->request->get('bdcar');
                    return [
                        'model' => $model,
                        'userid' => $userid,
                        'bdcar' => $bdcar,
                    ];
                }
            ],
           'update' => [
                'class' => UpdateAction::className(),
                'doUpdate' => function($id, array $postData) use($service){
                    return $service->update($id, $postData);
                },
                'data' => function($id, $updateResultModel, $updateAction) use($service){
                    $model = $updateResultModel === null ? $service->getDetail($id) : $updateResultModel;
                    return [
                        'model' => $model,
                    ];
                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'doDelete' => function($id)use($service){
                    return $service->delete($id);
                },
            ],
            'sort' => [
                'class' => SortAction::className(),
                'doSort' => function($id, $sort)use($service){
                    return $service->sort($id, $sort);
                },
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'data' => function($id, $viewAction) use($service){
                    return [
                        'model' => $service->getDetail($id),
                    ];
                },
            ],
        ];
    }
      /**
     * 更改报名人员状态，同时新建用户
     */
    public function actionUpstatus(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->getRequest()->getIsPost()) {
            $id        = Yii::$app->request->post('dataId');
            $value     = Yii::$app->request->post('selectedValue');
            $oldStatus = Yii::$app->request->post('oldStatus');
            $model     = RegistUsers::findOne($id);
            if ($model !== null) {
                $model->status = $value;
                if ($model->save()) {
                    if ($model->status == 3) {
                        $userModel                = new User();
                        $userModel->username      = $model->name;
                        $userModel->auth_key      = 'CVsVU8nvWEldP0F6SlSfACEe8mRXb--N';
                        $userModel->password_hash = '$2y$13$oKocgpXqtKkhbFgPigtqCuHVCTEdidMoagTGfgSod.4JMO1jjbh/.';
                        $userModel->created_at    = time();
                        $userModel->updated_at    = time();
                        $userModel->save();
                    }
                    return ['success' => true];
                } else {
                    return ['success' => false, 'error' => 'Failed to save the data.'];
                }
            }else {
                return ['success' => false, 'error' => 'User not found.'];
            }
           
        }
        return ['success' => false, 'error' => 'Invalid request.'];
    }
}
