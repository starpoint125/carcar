<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

use backend\grid\DateColumn;
use common\libs\Constants;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\RegistUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Regist Users';
$this->params['breadcrumbs'][] = yii::t('app', 'Regist Users');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        
                        ['class' => CheckboxColumn::className()],
                        'id',
                        'name',
                        'phone',
                        'address',
                        [
                            'attribute' => 'uid',
                            'value' => function ($model) {
                                if (!empty($model->uid)) {
                                    $username = User::findOne($model->uid);
                                    return $username->username;
                                }else{
                                    return '';
                                }
                            },
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model){
                                $selectOptions = Constants::getBmemberItems();
                                $selectedValue = $model->status; 
                                $select = Html::dropDownList('status', $selectedValue, $selectOptions, [
                                    'class' => 'form-control custom-select',
                                    'data-id' => $model->id, // 存储数据ID
                                    'data-status' => $model->status, 
                                ]);
                                return $select;
                            },
                            'filter' => Constants::getBmemberItems(),
                        ],
                        'remark:ntext',
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'created_at',
                        ],
                        ['class' => ActionColumn::className(),],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
    /**
     * 修改报名人员状态
     */
    $ajaxUrl = Yii::$app->urlManager->createUrl(['regist-users/upstatus']); 
    $js = <<<JS
        // 监听下拉列表变化事件
        $('select[name="status"]').change(function () {
            var selectedValue   = $(this).val(); // 获取所选值
            var dataId          = $(this).data('id'); // 获取数据ID
            var oldStatus       = $(this).data('status'); // 获取数据ID
            $.ajax({
                url: '$ajaxUrl',
                type: 'POST',
                data: {selectedValue: selectedValue, dataId: dataId,oldStatus:oldStatus}, // 传递所选值到API
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