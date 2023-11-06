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
           
            <div class="form-group" style="margin-right: 50px">
                <?= Html::submitButton(Yii::t('frontend', '立即报名'), ['class' => 'btn btn-primary', 'name' => '立即报名']) ?>
            </div>
        <?php ActiveForm::end(); ?>
</div>
