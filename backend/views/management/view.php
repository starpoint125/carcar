<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\form\Cartype;
use yii\helpers\ArrayHelper;
use common\libs\Constants;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\form\Management */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => function($model){
                    return "<img class='img-responsive' src='{$model->avatar}' width='100' height='100'>";
                }
            ],
            [
                'attribute' =>'cartype_id',
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
            ],
            'money',
            'deposit',
            [
                'attribute' => 'recommend',
                'value' => function($model){
                    return Constants::getCarRecommendItems($model->recommend);
                },
                'filter' => Constants::getCarRecommendItems(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
