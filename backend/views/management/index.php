<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;
use common\libs\Constants;
use backend\grid\DateColumn;
use backend\grid\SortColumn;
use backend\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\form\Cartype;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Managements';
$this->params['breadcrumbs'][] = yii::t('app', 'Management');
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget() ?>
                <?php //$this->render('_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                        'name',
                        [
                            'attribute' => 'avatar',
                            'format' => 'raw',
                            'value' => function($model){
                                return "<img class='img-responsive' src='{$model->avatar}'>";
                            }
                        ],
                        [
                            'attribute' =>'cartype_id',
                            'filter'    => Html::activeDropDownList($searchModel, 'cartype_id',ArrayHelper::map(\backend\models\form\Cartype::find()->orderBy('id desc')->all(),'id','type_name')      , ['prompt' => '全部', "class" => "form-control "]),
                            'value'     => function ($data){
                                if(!empty($data->cartype_id)){
                                    return ArrayHelper::map(\backend\models\form\Cartype::find()->all(),'id','type_name')[trim($data->cartype_id)];
                                }else{
                                    return '其它';
                                }
                            },
                        ],
                        [
                            'attribute' => 'type',
                            'value' => function($model){
                                return Constants::getCarTypesItems($model->type);
                            },
                            'filter' => Constants::getCarTypesItems(),
                        ],
                        [
                            'attribute' => 'seat_num',
                            'value' => function($model){
                                return Constants::getCarSiteItems($model->seat_num);
                            },
                            'filter' => Constants::getCarSiteItems(),
                        ],
                        [
                            'attribute' => 'door_num',
                            'value' => function($model){
                                return Constants::getCarDoorsItems($model->door_num);
                            },
                            'filter' => Constants::getCarDoorsItems(),
                        ],
                        [
                            'attribute' => 'gear_position',
                            'value' => function($model){
                                return Constants::getCarPositionItems($model->gear_position);
                            },
                            'filter' => Constants::getCarPositionItems(),
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($model){
                                return Constants::getCarStatusItems($model->status);
                            },
                            'filter' => Constants::getCarStatusItems(),
                            'format' => 'raw', // 使用 raw 格式
                            'contentOptions' => function ($model) {
                                $color = '';
                                switch ($model->status) {
                                    case Constants::COMMENT_PUBLISH:
                                        $color = 'green'; // 使用中绿色
                                        $background = 'lightgreen'; // 使用中背景色
                                        break;
                                    case Constants::COMMENT_INITIAL:
                                        $color = 'gray'; // 闲置中灰色
                                        $background = 'lightgray';
                                        break;
                                    // 添加其他状态的情况
                                }
                                return ['style' => "color: $color; background-color: $background;"];
                            },
                        ],
                        // 'money',
                        // 'deposit',
                        [
                            'attribute' => 'recommend',
                            'value' => function($model){
                                return Constants::getCarRecommendItems($model->recommend);
                            },
                            'filter' => Constants::getCarRecommendItems(),
                        ],
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
