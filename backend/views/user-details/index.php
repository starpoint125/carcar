<?php
use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

use common\libs\Constants;
use backend\grid\DateColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use backend\grid\SortColumn;
use yii\helpers\ArrayHelper;
use common\models\User;
use backend\models\form\Management;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Details';
$this->params['breadcrumbs'][] = yii::t('app', 'User Details');

$userId = Yii::$app->user->identity->id;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <div class="mail-tools tooltip-demo m-t-md"> 
                    <?php 
                        if (!in_array($userId,Constants::SUPERID)) {
                    ?>
                        <a class="btn btn-white btn-sm multi-back" href="<?=Yii::$app->urlManager->createUrl(['user/index'])?>" title="返回">
                            <i class="fa fa-back"></i> 返回
                        </a>
                    <?php
                        }
                    ?>
                    
                    <a class="btn btn-white btn-sm refresh" href="<?=Yii::$app->urlManager->createUrl(['user-details/refresh'])?>" title="刷新" data-pjax="0">
                        <i class="fa fa-refresh"></i> 刷新
                    </a> 
                    <a class="btn btn-white btn-sm" href="<?=Yii::$app->urlManager->createUrl(['user-details/create','userid'=>Yii::$app->request->get('userid'),'bdcar'=>Yii::$app->request->get('bdcar')])?>" title="创建" data-pjax="0">
                        <i class="fa fa-plus"></i> 创建
                    </a> 
                    <a style="display: ;" class="btn btn-white btn-sm multi-operate" href="<?=Yii::$app->urlManager->createUrl(['user-details/delete'])?>" title="删除" data-pjax="0" data-confirm="真的要删除吗？">
                        <i class="fa fa-trash-o"></i> 删除
                    </a>
                </div>
                <?php //$this->render('_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showFooter' => true, // 启用底部汇总行
                    'columns' => [
                        ['class' => CheckboxColumn::className()],
                       
                        [
                            'attribute'=>'userid',
                            'filter'=>false,
                            'value'=>function($model){
                                $userData = User::findUseridByname($model->userid);
                                return $userData->username;
                            }
                        ],
                        [
                            'attribute'=>'car_management_id',
                            'filter'=>false,
                            'value'=>function($model){
                                $userData = Management::getCarList($model->userid);
                                return $userData->name;
                            }
                        ],
                        'income',
                        'expenses',
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'date',
                        ],
                        'remark:ntext',
                        [
                            'class' => DateColumn::className(),
                            'attribute' => 'created_at',
                        ],
                        ['class' => ActionColumn::className(),],
                    ],
                    'footerRowOptions' => ['style' => 'font-weight:bold;'],
                    'afterRow' => function ($model, $key, $index, $grid) use ($dataProvider) {
                        if ($index === count($dataProvider->getModels()) - 1) {                  
                            $incomeTotal = 0;
                            $expensesTotal = 0;
                    
                            foreach ($dataProvider->getModels() as $model) {
                                $incomeTotal += $model->income;
                                $expensesTotal += $model->expenses;
                            }
                            $difference = $incomeTotal - $expensesTotal;
                            $alldata = [
                                'income' => '<strong>总收入：' . $incomeTotal . '元</strong>',
                                'expenses' => '<strong>总支出：' . $expensesTotal . '元</strong>',
                                'difference' => '<strong>差值：' . $difference . '元</strong>',
                            ];
                            // 返回总计数据作为一个单元格
                            return '<td colspan="8">' . $alldata['income'] . ' ' . $alldata['expenses'] . ' ' . $alldata['difference'] . '</td>';
                        }else{
                            return '';
                        }
                    },
                ]); ?>
            </div>
        </div>
    </div>
</div>
