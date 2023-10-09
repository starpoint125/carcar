<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\libs\Constants;
use backend\grid\DateColumn;
use yii\helpers\Url;
use backend\grid\SortColumn;
use yii\helpers\ArrayHelper;
use common\models\User;
use backend\models\form\Management;
/* @var $this yii\web\View */
/* @var $model backend\models\form\UserDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'userid',
                'filter'=>false,
                'value'=>function($model){
                    $userData = User::findUseridByname($model->userid);
                    return $userData->username;
                }
            ],
            [
                'attribute'=>'car_management_id',
                'filter'=>false,
                'value'=>function($model){
                    $userData = Management::getCarList($model->userid);
                    return $userData->name;
                }
            ],
            'date:datetime',
            'income',
            'expenses',
            'remark:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
