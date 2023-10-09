<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\form\UserDetails */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'User Details'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', 'User Details')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>
