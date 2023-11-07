<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2016-03-23 17:51
 */

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel backend\models\search\AdminUserSearch
 */

use backend\grid\DateColumn;
use backend\grid\GridView;
use common\models\User;
use common\models\RegistUsers;
use backend\models\form\Management;
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Users';
$this->params['breadcrumbs'][] = Yii::t('app', 'Users');
?>
<style>
.custom-select {
    width: 150px; /* 设置宽度为200px，根据需要进行调整 */
}
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget([
                    'template' => '{refresh} {create} {delete}',
                ]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                        ],
                        [
                            'width' => '80',
                            'attribute' => 'username',
                        ],
                        // [
                        //     'attribute' => 'avatar',
                        //     'format' => 'raw',
                        //     'value' => function($model){
                        //         return "<img class='img-responsive' src='{$model->avatar}'>";
                        //     }
                        // ],
                        [
                            'attribute' => 'mpic',
                            'format' => 'raw',
                            'width' => '80',
                            'value' => function($model){
                                if ($model->mpic) {
                                    // return "<img class='img-responsive' src='{$model->mpic}'>";
                                    return "<a href='{$model->mpic}' download><img class='img-responsive' src='{$model->mpic}'></a>";
                                }else{
                                    // $url = Yii::$app->urlManager->createUrl(['user/mpic', 'uid' => $model->id]);
                                    return "<a href='#' class='ma' uid='{$model->id}'>生成二维码</a>";
                                }
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'label' => Yii::t('app', 'Status'),
                            'value' => function ($model) {
                                if($model->status == User::STATUS_ACTIVE){
                                    return Yii::t('app', 'Normal');
                                }else if( $model->status == User::STATUS_DELETED ){
                                    return Yii::t('app', 'Disabled');
                                }
                            },
                            'filter' => User::getStatuses(),
                        ],
                        [
                            'width' => '100',
                            'attribute' => 'idcard',
                        ],
                        [
                            'label' => '绑定车辆',
                            'format' => 'raw',
                            'value' => function ($model) {
                                    $selectOptions = ArrayHelper::map(\backend\models\form\Management::find()->select(['id', 'name'])->all(), 'id', 'name');//->where(['status'=>0])
                                    $selectOptions = ['' => '请选择'] + $selectOptions; // 添加一个空选项
                                    $selectedValue = $model->bdcar; // 获取model->bdcar的值
                                    $select = Html::dropDownList('bdcar', $selectedValue, $selectOptions, [
                                        'class' => 'form-control custom-select',
                                        'data-id' => $model->id, // 存储数据ID
                                        'data-carid' => $model->bdcar, 
                                    ]);
                                return $select;
                            },
                        ],
                        [
                            'attribute'=>'money',
                            'format' => 'raw',
                            'value'=>function($model){
                                $regCount = RegistUsers::find()->where(['uid'=>$model->id,'status'=>3])->count();
                                $ymong = $regCount * Yii::$app->params['commission'];
                                $money = $model->money - $ymong;
                                return $money;
                            },
                        ],
                        [
                            'attribute'=>'commission',
                            'format' => 'raw',
                            'value'=>function($model){
                                $regCount = RegistUsers::find()->where(['uid'=>$model->id,'status'=>3])->count();
                                $ymong = $regCount * Yii::$app->params['commission'];
                                return $ymong;
                            },
                        ],
                        [
                            'label' => '消费明细',
                            'format' => 'raw',
                            'width' => '80',
                            'value' => function ($model) {
                                if ($model->bdcar != '') {
                                    // 生成链接到自定义页面的超链接
                                    $url = Yii::$app->urlManager->createUrl(['user-details/index', 'userid' => $model->id,'bdcar'=>$model->bdcar]);
                                    return "<a href='{$url}'>消费明细</a>";
                                }else{
                                    return ''; // 当bdcar为空时不显示链接
                                }
                            },
                        ],
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'created_at',
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'width' => '190px',
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<div id="flash-container">
    <?php foreach (Yii::$app->session->getAllFlashes() as $key => $message): ?>
        <div class="alert alert-<?= $key ?>">
            <?= $message ?>
        </div>
    <?php endforeach; ?>
</div>
<?php
    $ajaxUrls = Yii::$app->urlManager->createUrl(['user/mpic']); 
    $jss = <<<JS
        $('.ma').click(function () {
            var uid = $(this).attr('uid'); // 获取数据ID
            $.ajax({
                url: '$ajaxUrls',
                type: 'POST',
                data: {uid: uid}, // 传递所选值到API
                success: function (response) {
                    // 处理接口响应
                    if (response.success) {
                        $('#flash-container').html('<div class="alert alert-success">' + response.successMessage + '</div>');
                        // 成功后刷新当前页
                        location.reload();
                    }
                    console.log(response);
                    // 在这里你可以执行其他操作，例如显示响应数据、刷新GridView等
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    JS;
    $this->registerJs($jss);
?>

<?php
    /**
     * 用户绑定车辆
     */
    $ajaxUrl = Yii::$app->urlManager->createUrl(['user/bdcar']); // 替换成你的API接口路由
    $js = <<<JS
        // 监听下拉列表变化事件
        $('select[name="bdcar"]').change(function () {
            var selectedValue = $(this).val(); // 获取所选值
            var dataId = $(this).data('id'); // 获取数据ID
            var oldCarId = $(this).data('carid'); // 获取数据ID
            $.ajax({
                url: '$ajaxUrl',
                type: 'POST',
                data: {selectedValue: selectedValue, dataId: dataId,oldCarId:oldCarId}, // 传递所选值到API
                success: function (response) {
                    // 处理接口响应
                    if (response.success) {
                        $('#flash-container').html('<div class="alert alert-success">' + response.successMessage + '</div>');
                        // 成功后刷新当前页
                        location.reload();
                    }
                    console.log(response);
                    // 在这里你可以执行其他操作，例如显示响应数据、刷新GridView等
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    JS;
    $this->registerJs($js);
?>