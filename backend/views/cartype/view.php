<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\libs\Constants;
/* @var $this yii\web\View */
/* @var $model backend\models\form\Cartype */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cartypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cartype-view">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type_name',
            [
                'attribute' => 'type',
                'value' => function($model){
                    return Constants::getCarTypeItems($model->type);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime'
        ],
    ]) ?>

</div>
