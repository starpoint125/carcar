<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

use common\libs\Constants;
use backend\grid\DateColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = yii::t('app', 'Order');
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
                        // 'id',
                        'order_number',
                        'uid',
                        'car_id',
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'reservation_time',
                        ],
                        'price',
                        'car_rental_fee',
                        'deposit',
                        'insurance_expenses',
                        'total_cost',
                        [
                            'attribute' => 'status',
                            'value' => function($model){
                                return Constants::getOrderStatusItems($model->deposit_status);
                            },
                            'filter' => Constants::getOrderStatusItems(),
                        ],
                        [
                            'attribute' => 'deposit_status',
                            'value' => function($model){
                                return Constants::getDepositStatusItems($model->deposit_status);
                            },
                            'filter' => Constants::getDepositStatusItems(),
                        ],
                        [
                            'attribute' => 'extraction_method',
                            'value' => function($model){
                                return Constants::getExtractionMethodItems($model->extraction_method);
                            },
                            'filter' => Constants::getExtractionMethodItems(),
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
