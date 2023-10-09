<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-03-15 21:16
 */

namespace backend\controllers;

use Yii;
use backend\actions\ViewAction;
use common\services\MenuServiceInterface;
use common\models\Menu;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\actions\SortAction;
use yii\helpers\ArrayHelper;

/**
 * Menu management
 * - data:
 *          table menu
 *          column `type` value is \common\models\Menu::TYPE_BACKEND records
 * - description:
 *          backend menu management
 *
 * Class MenuController
 * @package backend\controllers
 */
class MenuController extends \yii\web\Controller
{

    /**
     * @auth
     * - item group=菜单 category=后台 description-get=列表 sort=210 method=get
     * - item group=菜单 category=后台 description-get=查看 sort=211 method=get  
     * - item group=菜单 category=后台 description=创建 sort-get=212 sort-post=213 method=get,post  
     * - item group=菜单 category=后台 description=修改 sort-get=214 sort-post=215 method=get,post  
     * - item group=菜单 category=后台 description-post=删除 sort=216 method=post  
     * - item group=菜单 category=后台 description-post=排序 sort=217 method=post  
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actions()
    {
        /** @var MenuServiceInterface $service */
        $service = Yii::$app->get(MenuServiceInterface::ServiceName);
        return [
            'index' => [
                'class' => IndexAction::className(),
                'data' => function(array $query)use($service){
                    $result = $service->getList($query, ['type'=>Menu::TYPE_BACKEND]);
                    $data = [
                        'dataProvider' => $result['dataProvider'],
                        'searchModel' => $result['searchModel'],
                    ];
                    return $data;
                }
            ],
            'view-layer' => [
                'class' => ViewAction::className(),
                'data' => function($id)use($service){
                    return [
                        'model'=>$service->getDetail($id)
                    ];
                },
            ],
            'create' => [
                'class' => CreateAction::className(),
                'doCreate' => function($postData)use($service) {
                    return $service->create($postData, ['type' => Menu::TYPE_BACKEND]);
                },
                'data' => function($createResultModel) use($service){
                    $model = $createResultModel === null ? $service->newModel(['type'=> Menu::TYPE_BACKEND]) : $createResultModel;
                    return [
                        'model'=>$model,
                        'menusNameWithPrefixLevelCharacters' => ArrayHelper::getColumn($service->getLevelMenusWithPrefixLevelCharacters(Menu::TYPE_BACKEND), "prefix_level_name"),
                        'parentMenuDisabledOptions' => [],
                    ];
                },
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'doUpdate' => function($id, $postData)use($service) {
                    return $service->update($id, $postData);
                },
                'data' => function($id, $updateResultModel)use($service){
                    $model = $updateResultModel === null ? $service->getDetail($id) : $updateResultModel;

                    $parentMenuDisabledOptions = [];
                    $parentMenuDisabledOptions[$id] = ['disabled' => true];//cannot be themselves' sub menu

                    $descendants = $model->getDescendants($id, Menu::TYPE_BACKEND);
                    $descendants = ArrayHelper::getColumn($descendants, 'id');
                    foreach ($descendants as $descendant){//cannot be themselves's sub menu's menu
                        $parentMenuDisabledOptions[$descendant] = ['disabled' => true];
                    }

                    return [
                        'model' => $model,
                        'menusNameWithPrefixLevelCharacters' => ArrayHelper::getColumn($service->getLevelMenusWithPrefixLevelCharacters(Menu::TYPE_BACKEND), "prefix_level_name"),
                        'parentMenuDisabledOptions' => $parentMenuDisabledOptions,
                    ];
                },
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
        ];
    }

}
