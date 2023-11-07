<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', '报名') . '-' . Yii::$app->feehi->website_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        width: 300px;
        padding: 16px;
        background-color: white;
        margin: 100px auto;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 6px;
        margin-bottom: 16px;
    }
    input[type=submit] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }
    input[type=submit]:hover {
        background-color: #45a049;
    }
    .help-block-error{
        color:red;
    }
    .center-button {
        text-align: center;
    }
    .section-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 20px 0;
    }
    .info-list {
        list-style: none;
        padding: 0;
    }

    .info-list ul {
        margin-left: 20px;
    }

    .info-list li {
        font-weight: bold;
        margin-top: 10px;
    }
</style>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?= \yii\bootstrap\Alert::widget([
        'options' => ['class' => 'alert-success'],
        'body' => Yii::$app->session->getFlash('success'),
    ]) ?>
<?php endif; ?>
<div class="content-wrap ">
        <legend>基本信息</legend>
        <?php $form = ActiveForm::begin(['id' => 'form-login']); ?>
            <?= Html::activeHiddenInput($model,'uid',['value'=>$uid]) ?>

            <?= $form->field($model, 'name', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'phone', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true,'maxlength'=>11]) ?>

            <?= $form->field($model, 'address', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'remark', ['template' => "<div style='position:relative'>{label}{input}\n{error}\n{hint}</div>"])->textarea(['autofocus' => true]) ?>
           
            <div class="form-group center-button" >
                <?= Html::submitButton(Yii::t('frontend', '立即报名'), ['class' => 'btn btn-primary', 'name' => '立即报名']) ?>
                <?= Html::a(Yii::t('frontend', '推广人订单'), ['site/subordinate','uid'=>$uid],['class' => 'btn btn-primary', 'name' => '推广人订单']) ?>
            </div>
           
            <br><br><br>
        <?php ActiveForm::end(); ?>
</div>
<br><br>
<div >
    <div class="section-title"> 注册要求</div>
    <ul class="info-list">
        <li> 司机准入标准</li>
        <ul>
            <li>年龄: 男21-60周岁、女22-55周岁</li>
            <li>具有3年（含）以上驾龄，C2（含）以上驾照</li>
            <li>无犯罪记录：包括无危险驾驶罪、无暴力犯罪、无吸毒记录等、无交通肇事犯罪、无酒驾等严重交通违法记录</li>
            <li>4.其他：参考所在城市网约车从业标准准入条件</li>
        </ul>
        <li>车辆准入标准</li>
        <ul>
            <li>性质：当地车牌，符合当地网约车细则</li>
            <li>车龄：车龄小于8年(具体以当地要求为准)</li>
            <li>车况：无明显伤痕、无改装</li>
            <li>保险：符合当地网约车新政策要求险种及保额</li>
        </ul>
    </ul>
    <div class="section-title">常见问题</div>
    <ul class="info-list">
        <li>我的车符合要求,但是列表里没有我的车型,怎么办?</li>
        <p>您可致电客服13426292391,告知您所在的城市,车型品牌,型号,如您提报的车型符合网约车规范,工作人员会尽快添加车型.或者您可联系所属的加盟商新增车型.</p>

        <li>注册时,显示信息(手机号，车辆信息)被占用, 怎么办?</li>
        <p>您可致电客服13426292391,提供您被占用的手机号/车牌号,客服会同步城市运营经理协助查询.</p>

        <li>信息提交后,如何知道审核进度?</li>
        <p>信息提交后,会有专业客服第一时间半小时内回电您.</p>

        <li>我想加入,平台分成是多少?</li>
        <p>平台分成比例位列行业前茅,收入可观.更有冲单奖,流水翻倍,出勤奖还有免抽佣活动等着你哟！期待您的加入,为乘客提供高品质的出行服务.</p>
    </ul>
</div>
