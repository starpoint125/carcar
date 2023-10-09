<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 12:08
 */

namespace backend\controllers;

use Yii;
use backend\actions\DoAction;
use backend\actions\CreateAction;
use common\services\SettingServiceInterface;
use backend\actions\UpdateAction;
use backend\actions\DeleteAction;
use common\models\Options;

/**
 * Setting management
 * - data:
 *          table options
 *          column `type` value is \common\models\Options::TYPE_SYSTEM|TYPE_CUSTOM records
 *
 * Class SettingController
 * @package backend\controllers
 */
class SettingController extends \yii\web\Controller
{

    /**
     * @auth
     * - item group=设置 category=网站设置 description=网站设置 sort-get=100 sort-post=101 method=get,post
     * - item group=设置 category=自定义设置 description=修改 sort-get=130 sort-post=131 method=get,post
     * - item group=设置 category=自定义设置 description-post=删除  sort=132 method=post
     * - item group=设置 category=自定义设置 description=自定义设置创建 sort-get=133 sort-post=134 method=get,post
     * - item group=设置 category=自定义设置 description=自定义设置修改 sort-get=135 sort-post=136 method=get,post
     * - item group=设置 category=smtp设置 description=修改 sort-get=110 sort-post=111 method=get,post
     * - item group=设置 category=smtp设置 description-post=测试stmp设置 sort-post=112 method=post
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actions()
    {
        /** @var SettingServiceInterface $service */
        $service = Yii::$app->get(SettingServiceInterface::ServiceName);
        return [
            'website' => [
                "class" => UpdateAction::className(),
                'primaryKeyIdentity' => null,
                'doUpdate' => function($postData)use($service){
                    return $service->updateWebsiteSetting($postData);
                },
                "data" => function($updateResultModel)use($service){
                    $model = $updateResultModel === null ? $service->getModel("website") : $updateResultModel;
                    return [
                        "model" => $model,
                    ];
                },
                'successRedirect' => ["setting/website"]
            ],
            'custom' => [
                'class' => UpdateAction::className(),
                'primaryKeyIdentity' => null,
                "doUpdate" => function($postData)use($service){
                    return $service->updateCustomSetting($postData);
                },
                "data" => function($updateResultModel) use($service){
                    $model = $updateResultModel === null ? $service->getModel("custom") : $updateResultModel;
                    return [
                        'settings' => $model,
                        'model' => $service->newModel(),
                    ];
                },
                'successRedirect' => ["setting/custom"]
            ],
            "custom-delete" => [
                "class" => DeleteAction::className(),
                "doDelete" => function($id)use($service){
                    return $service->delete($id);
                },
            ],
            'custom-create' => [
                "class" => CreateAction::className(),
                'doCreate' => function($postData) use($service) {
                    return $service->create($postData, ['type' => Options::TYPE_CUSTOM]);
                },
                "data" => function($createResultModel)use($service){
                    $model = $createResultModel === null ? $service->newModel(['type'=>Options::TYPE_CUSTOM]) : $createResultModel;
                    return [
                        'model' => $model,
                    ];
                },
            ],
            'custom-update' => [
                "class" => UpdateAction::className(),
                'doUpdate' => function($id, $postData)use($service){
                    return $service->update($id, $postData);
                },
                "data" => function($id, $updateResultModel)use($service){
                    $this->layout = false;
                    $model = $updateResultModel === null ? $service->getModel($id) : $updateResultModel;
                    return [
                        'model' => $model,
                    ];
                },
            ],
            "smtp" => [
                "class" => UpdateAction::className(),
                'primaryKeyIdentity' => null,
                "doUpdate" => function($postData)use($service){
                   return $service->updateSMTPSetting($postData);
                },
                "data" => function($updateResultModel) use($service){
                    $model = $updateResultModel === null ? $service->getModel("smtp") : $updateResultModel;
                    return [
                        "model" => $model,
                    ];
                },
                'successRedirect' => ['setting/smtp']
            ],
            'test-smtp' => [
                'class' => DoAction::className(),
                'primaryKeyIdentity' => null,
                'do' => function($postData) use($service) {
                    return $service->testSMTPSetting($postData);
                },
            ],
        ];
    }
}
