<?php

use backend\widgets\ActiveForm;
use backend\models\form\Cartype;
use yii\helpers\ArrayHelper;
use common\libs\Constants;
/* @var $this yii\web\View */
/* @var $model backend\models\form\Management */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <div class="hr-line-dashed"></div>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'avatar')->imgInput(['width'=>150,'height'=>150]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'cartype_id',['size' => 2,])->dropDownList(ArrayHelper::map( \backend\models\form\Cartype::find()->select(['id','type_name'])->orderBy('created_at desc')->all(), 'id', 'type_name')) ?>

                        <div class="hr-line-dashed"></div>
                        
                        <?= $form->field($model, 'type', ['size' => 2,])->dropDownList(Constants::getCarTypesItems()); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'seat_num', ['size' => 2,])->dropDownList(Constants::getCarSiteItems()); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'door_num', ['size' => 2,])->dropDownList(Constants::getCarDoorsItems()); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'gear_position', ['size' => 2,])->dropDownList(Constants::getCarPositionItems()); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'status', ['size' => 2,])->dropDownList(Constants::getCarStatusItems()); ?>
                        <div class="hr-line-dashed"></div>
                        
                        <?= $form->field($model, 'money', ['size' => 2,])->textInput(['maxlength' => 50]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'deposit', ['size' => 2,])->textInput(['maxlength' => 50]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'recommend', ['size' => 2,])->dropDownList(Constants::getCarRecommendItems()); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>