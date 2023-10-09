<?php

namespace backend\models\form;

use Yii;
use common\helpers\Util;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use Exception;
/**
 * This is the model class for table "{{%user_details}}".
 *
 * @property int $id
 * @property int $userid 用户id
 * @property int $car_management_id 车辆id
 * @property string $date 日期
 * @property string $income 收入
 * @property string $expenses 支出
 * @property string $remark 备注
 * @property int $created_at
 * @property int $updated_at
 */
class UserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'car_management_id', 'created_at', 'updated_at'], 'integer'],
            [['income'], 'required'],
            [['date'], 'safe'],
            [['income', 'expenses'], 'number'],
            [['remark'], 'string'],
        ];
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userid' => Yii::t('app', '用户'),//id
            'car_management_id' => Yii::t('app', '车辆'),//id
            'date' => Yii::t('app', '日期'),
            'income' => Yii::t('app', '收入'),
            'expenses' => Yii::t('app', '支出'),
            'remark' => Yii::t('app', '备注'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
}
