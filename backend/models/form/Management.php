<?php

namespace backend\models\form;
use yii\behaviors\TimestampBehavior;
use Yii;
use common\helpers\Util;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use Exception;
/**
 * This is the model class for table "{{%management}}".
 *
 * @property int $id
 * @property string $name 车辆名称
 * @property string $avatar 车辆主图
 * @property int $cartype_id 品牌id
 * @property int $type 类型
 * @property int $seat_num 座位数
 * @property int $door_num 门数
 * @property int $gear_position 档位 0自动档1手动档
 * @property int $status 状态 0开启1禁用
 * @property int $recommend 推荐0无1推荐
 * @property int $created_at
 * @property int $updated_at
 */
class Management extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%management}}';
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
    public function rules()
    {
        return [
            [['cartype_id', 'type', 'seat_num', 'door_num', 'gear_position', 'status', 'recommend', 'created_at', 'updated_at'], 'integer'],
            [['cartype_id','name', 'type', 'seat_num', 'door_num', 'gear_position', 'status', 'recommend', 'created_at', 'updated_at','money','deposit'], 'required'],
            [['name', 'avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '车辆名称'),
            'avatar' => Yii::t('app', '车辆主图'),
            'cartype_id' => Yii::t('app', '品牌'),
            'type' => Yii::t('app', '类型'),
            'seat_num' => Yii::t('app', '座位数'),
            'door_num' => Yii::t('app', '门数'),
            'gear_position' => Yii::t('app', '档位'),// 0自动档1手动档
            'status' => Yii::t('app', '状态'),// 0开启1禁用
            'recommend' => Yii::t('app', '推荐'),//0无1推荐
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'money' => Yii::t('app', '租金'),
            'deposit' => Yii::t('app', '押金'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
       
        Util::handleModelSingleFileUpload($this, 'avatar', $insert, '@frontend/web/uploads/avatar/');
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if( empty($this->avatar) ) return true;
        try {
            Util::deleteThumbnails(Yii::getAlias('@frontend/web') . $this->avatar, [], true);
        }catch (Exception $exception){
            $this->addError("avatar", $exception->getMessage());
            return false;
        }
        return true;
    }
    /**
     * 获取所有车辆
     */
    public static function getCarList($carId){
        return static::findOne(['id' => $carId]);//, 'status' => self::STATUS_ACTIVE
    }

     /**
     * 获取所有车辆
     */
    public static function getCarData($carId){
        return static::findOne(['id' => $carId]);//, 'status' => self::STATUS_ACTIVE
    }

    public static function findByCarData($carId)
    {
        $data = static::find()->select(['id','name'])->where(['id'=>$carId])->asArray()->one();
        return [$data['id']=>$data['name']];
    }
}
