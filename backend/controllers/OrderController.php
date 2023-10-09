<?php

namespace backend\controllers;

use Yii;
use common\services\OrderServiceInterface;
use common\services\OrderService;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use backend\actions\ViewAction;
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends \yii\web\Controller
{
    /**
    * @auth
    * - item group=未分类 category=Orders description-get=列表 sort=000 method=get
    * - item group=未分类 category=Orders description=创建 sort-get=001 sort-post=002 method=get,post
    * - item group=未分类 category=Orders description=修改 sort=003 sort-post=004 method=get,post
    * - item group=未分类 category=Orders description-post=删除 sort=005 method=post
    * - item group=未分类 category=Orders description-post=排序 sort=006 method=post
    * - item group=未分类 category=Orders description-get=查看 sort=007 method=get
    * @return array
    */
    public function actions()
    {
        /** @var OrderServiceInterface $service */
        $service = Yii::$app->get(OrderServiceInterface::ServiceName);
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function($query, $indexAction) use($service){
                    $result = $service->getList($query);
                    return [
                        'dataProvider' => $result['dataProvider'],
                        'searchModel' => $result['searchModel'],                    ];
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'doCreate' => function(array $postData) use($service){
                    return $service->create($postData);
                },
                'data' => function($createResultModel, $createAction) use($service){
                    $model = $createResultModel === null ? $service->newModel() : $createResultModel;
                    return [
                        'model' => $model,
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
                'data' => function($id) use($service){
                    return [
                        'model' => $service->getDetail($id),
                    ];
                },
            ],
        ];
    }
}
