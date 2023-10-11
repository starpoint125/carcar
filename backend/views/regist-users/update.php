<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\RegistUsers */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Regist Users'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'Regist Users')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
