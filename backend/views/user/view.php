<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2018-02-24 13:38
 */

use common\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'username',
        'idcard',
        'email',
        [
            'attribute' => 'avatar',
            'format' => 'raw',
            'value' => function($model){
                if( empty( $model->avatar ) ) return '-';
                return "<img style='max-width:100px;max-height:100px' src='" . $model->avatar . "'>";
            }
        ],
        [
            'attribute' => 'status',
            'value' => function ($model) {
                if($model->status == User::STATUS_ACTIVE){
                    return Yii::t('app', 'Normal');
                }else if( $model->status == User::STATUS_DELETED ) {
                    return Yii::t('app', 'Disabled');
                }
            }
        ],
        [
            'attribute' => 'mpic',
            'format' => 'raw',
            'value' => function($model){
                if ($model->mpic) {
                    return "<a href='{$model->mpic}' download><img class='img-responsive' style='max-width:100px;max-height:100px' src='{$model->mpic}'></a>";
                }else{
                    return "";
                }
            }
        ],
        'money',
        'lu_money',
        'passport',
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>