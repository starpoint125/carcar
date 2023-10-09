<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\form\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_number',
            'uid',
            'car_id',
            'reservation_time',
            'price',
            'car_rental_fee',
            'deposit',
            'insurance_expenses',
            'total_cost',
            'status',
            'deposit_status',
            'extraction_method',
            'created_at',
        ],
    ]) ?>

</div>
