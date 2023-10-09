<?php
/**
 * Author: lf
 * Blog: https://blog.feehi.com
 * Email: job@feehi.com
 * Created at: 2017-09-12 14:46
 */

/**
 * @var $this yii\web\View
 * @var $model backend\models\form\RBACPermissionForm
 * @var $groups []
 * @var $categories []
 */

use backend\widgets\ActiveForm;
use common\widgets\JsBlock;

$this->title = "Permissions";

?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'route')->textInput() ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'method')->dropDownList(['GET'=>'GET', 'POST'=>'POST']) ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'description')->textInput() ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'sort')->textInput() ?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'group', ['template'=>'{label}<div class="col-sm-{size}"><input name="groupType" checked value="new" type="radio">' . Yii::t('app', 'Input new') . ' &nbsp;&nbsp;<input value="select" name="groupType" type="radio">' . Yii::t('app', 'Chose from exists') . '<div class="form-group field-rbacpermissionform-group required">{input}</div>{error}</div>{hint}'])->textInput()?>
                <div class="hr-line-dashed"></div>
                <?= $form->field($model, 'category', ['template'=>'{label}<div class="col-sm-{size}"><input name="categoryType" checked value="new" type="radio">' . Yii::t('app', 'Input new') . ' &nbsp;&nbsp;<input value="select" name="categoryType" type="radio">' . Yii::t('app', 'Chose from exists') . '<div class="form-group field-rbacpermissionform-category required">{input}</div>{error}</div>{hint}'])->textInput()?>
                <div class="hr-line-dashed"></div>
                <?= $form->defaultButtons() ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php JsBlock::begin() ?>
<script>
    $(document).ready(function () {
       $("input[name=groupType]").change(function () {
           var val = $(this).val();
           var input;
           if( val === 'select' ){
               input = '<?= str_replace("\n", '', $form->field($model, 'group', ['template'=>'{input}'])->label(false)->dropDownList($groups) ) ?>';
           }else{
               input = '<?= str_replace("\n", '',$form->field($model, 'group', ['template'=>'{input}'])->label(false)->textInput() )?>';
           }
           $(this).parent().children("div.field-rbacpermissionform-group").remove();
           $(this).parent().append(input);
       })

        $("input[name=categoryType]").change(function () {
            var val = $(this).val();
            var input;
            if( val === 'select' ){
                input = '<?= str_replace("\n", '', $form->field($model, 'category', ['template'=>'{input}'])->label(false)->dropDownList($categories) ) ?>';
            }else{
                input = '<?= str_replace("\n", '',$form->field($model, 'category', ['template'=>'{input}'])->label(false)->textInput() )?>';
            }
            $(this).parent().children("div.field-rbacpermissionform-category").remove();
            $(this).parent().append(input);
        })
    })
</script>
<?php JsBlock::end() ?>
