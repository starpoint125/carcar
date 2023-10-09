<?php

use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\form\Cartype */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', 'Cartype'), 'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . yii::t('app', 'Cartype')],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>

