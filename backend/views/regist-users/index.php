<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

use backend\grid\DateColumn;
use common\libs\Constants;
use common\models\User;
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
                            'value' => function($model){
                                return Constants::getBmemberItems($model->status);
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
