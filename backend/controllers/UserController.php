<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-04-02 10:02
 */

namespace backend\controllers;

use Yii;
use common\services\UserServiceInterface;
use backend\actions\ViewAction;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use common\models\User;
use backend\models\form\Management;
use yii\web\Response;
/**
 * User management
 * - data:
 *          table user
 * - description:
 *          frontend register user management
 *
 * Class UserController
 * @package backend\controllers
 */
class UserController extends \yii\web\Controller
{

    /**
     * @auth
     * - item group=用户 category=前台用户 description-get=列表 sort=400 method=get
     * - item group=用户 category=前台用户 description-get=查看 sort=401 method=get  
     * - item group=用户 category=前台用户 description=创建 sort-get=402 sort-post=403 method=get,post  
     * - item group=用户 category=前台用户 description=修改 sort-get=404 sort-post=405 method=get,post  
     * - item group=用户 category=前台用户 description-post=删除 sort=406 method=post  
     * - item group=用户 category=前台用户 description-post=排序 sort=407 method=post  
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actions()
    {
        /** @var UserServiceInterface $service */
        $service = Yii::$app->get(UserServiceInterface::ServiceName);
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function($query)use($service){
                    $result = $service->getList($query);
                    return [
                        'dataProvider' => $result['dataProvider'],
                        'searchModel' => $result['searchModel'],
                    ];
                }
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'data' => function($id) use($service){
                    return [
                        'model' => $service->getDetail($id),
                    ];
                },
            ],
            'create' => [
                'class' => CreateAction::className(),
                'doCreate' => function($postData) use($service){
                    return $service->create($postData, ['scenario'=>'create']);
                },
                'data' => function($createResultModel) use($service){
                    $model = $createResultModel === null ? $service->newModel(['scenario'=>'create']) : $createResultModel;
                    return [
                        'model' => $model,
                    ];
                },
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'doUpdate' => function($id, $postData) use($service){
                    return $service->update($id, $postData, ['scenario'=>'update']);
                },
                'data' => function($id, $updateResultModel) use($service){
                    $model = $updateResultModel === null ? $service->getDetail($id, ['scenario'=>'update']) : $updateResultModel;
                    return [
                        'model' => $model,
                    ];
                },
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'doDelete' => function($id) use($service){
                    return $service->delete($id);
                },
            ],
            'sort' => [
                'class' => SortAction::className(),
                'doSort' => function($id, $sort) use($service){
                    return $service->sort($id, $sort);
                },
            ],
        ];
    }
    /**
     * 用户绑定车辆ID
     */
    public function actionBdcar(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->getRequest()->getIsPost()) {
            $id = Yii::$app->request->post('dataId');
            $value = Yii::$app->request->post('selectedValue');
            $oldCarId = Yii::$app->request->post('oldCarId');
            $model = User::findOne($id);
            if ($model !== null) {
                $model->bdcar = $value;
                if ($model->save()) {
                    //update old carid如果carid大于0则修改状态值，第一次则不修改
                    if ($oldCarId > 0) {
                        $modelo = Management::findOne($oldCarId);
                        $modelo->status = 0;
                        $modelo->save();
                    }
                    //update new carid
                    $modeln = Management::findOne($value);
                    $modeln->status = 1;
                    $modeln->save();
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