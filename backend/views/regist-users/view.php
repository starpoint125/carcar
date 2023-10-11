<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RegistUsers */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Regist Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regist-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'phone',
            'address',
            'remark:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
