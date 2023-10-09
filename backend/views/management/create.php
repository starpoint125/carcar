<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\form\Management */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Management'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Management')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

