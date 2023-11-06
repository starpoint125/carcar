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
use yii\helpers\Html;
use yii\helpers\Url;
use Da\QrCode\QrCode;
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
    /**
     * 生成二维码
     */
    public function  actionMpic(){
        $uid =  Yii::$app->request->post('uid');
        $url = Yii::$app->request->hostInfo . '/site/register.html?id='.$uid;
        $data['cashier']['url']='https://api.pwmqr.com/qrcode/create/?url='.urlencode($url);
        $data['cashier']['downUrl']='https://api.pwmqr.com/qrcode/create/?url='.urlencode($url)."&down=1";
        if ($uid) {
            $model = User::findOne($uid);
            $model->mpic = $data['cashier']['downUrl'];
            $model->save();
            return ['success' => true];
        }else {
            return ['success' => false, 'error' => 'Failed to save the data.'];
        }
    }

    public function actionDapic()
    {
        header('Content-Type: image/png');//解决输出乱码
        $qrcode = new QrCode('http://www.baidu.com');
        $qrcode->setSize(300);
        $code = $qrcode->writestring();
        exit($code);
        // // 定义二维码内容和海报图片路径
        // $qrCodeContent = 'https://example.com'; // 二维码内容
        // $posterImagePath = 'path_to_poster_image.jpg'; // 海报图片路径
        // // 创建二维码
        // QRcode::png($qrCodeContent, Yii::getAlias('@web/uploads/temp_qr_code.png'), 'H', 4);

        // // 打开生成的二维码图片和海报图片
        // $qrCodeImage = imagecreatefrompng(Yii::getAlias('@web/uploads/temp_qr_code.png'));
        // $posterImage = imagecreatefromjpeg($posterImagePath);

        // // 获取二维码和海报图片的宽度和高度
        // $qrCodeWidth = imagesx($qrCodeImage);
        // $qrCodeHeight = imagesy($qrCodeImage);
        // $posterWidth = imagesx($posterImage);
        // $posterHeight = imagesy($posterImage);

        // // 计算海报位置
        // $offsetX = $qrCodeWidth - $posterWidth; // 二维码右下角横坐标
        // $offsetY = $qrCodeHeight - $posterHeight; // 二维码右下角纵坐标

        // // 合并二维码和海报
        // imagecopy($qrCodeImage, $posterImage, $offsetX, $offsetY, 0, 0, $posterWidth, $posterHeight);

        // // 保存合并后的二维码带海报图片
        // imagepng($qrCodeImage, Yii::getAlias('@web/uploads/qr_code_with_poster.png'));

        // // 渲染视图并显示带有海报的二维码图片
        // return $this->render('qrCodeWithPoster', [
        //     'qrCodeImageUrl' => Url::to('@web/uploads/qr_code_with_poster.png', true),
        // ]);
    }
}