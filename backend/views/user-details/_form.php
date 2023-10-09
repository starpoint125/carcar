<?php

use backend\widgets\ActiveForm;
use common\models\User;
use backend\models\form\Management;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\form\UserDetails */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal'
                    ]
                ]); ?>
                <?php
                    $userid = Yii::$app->request->get('userid');
                    $bdcar = Yii::$app->request->get('bdcar');
                    //查询用户
                    $userById = User::findByUserid($userid);
                    $bdcarData = Management::findByCarData($bdcar);
                ?>
                <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'userid', ['size' => 2])->dropDownList($userById,[
                                'options' => [
                                    $userid => ['selected' => true] // 设置选中的项
                                ]
                            ]); 
                        ?>
                        <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'car_management_id', ['size' => 2])->dropDownList($bdcarData,[
                                'options' => [
                                    $bdcar => ['selected' => true] // 设置选中的项
                                ]
                            ]); 
                        ?>
                        <div class="hr-line-dashed"></div>
                        <?= $form->field($model, 'date', ['size' => 3])->widget(DateTimePicker::classname(), [
                              'options' => ['placeholder' => '','class' => 'export_start'],
                              'value'=>'',
                               'pluginOptions' => [
                                    'autoclose'      => true,
                                    'format'         => 'yyyy-mm-dd',
                                    'minView'        => "month",
                                    'startDate'      => date("Y-m-d"),
                                    'todayHighlight' => true,
                              ]
                          ]); ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'income', ['size' => 2])->textInput(['maxlength' => true])->input('text', ['append' => '元']) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'expenses', ['size' => 2])->textInput(['maxlength' => true])->input('text', ['append' => '元']) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>
                        <div class="hr-line-dashed"></div>

                        <?= $form->defaultButtons() ?>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>