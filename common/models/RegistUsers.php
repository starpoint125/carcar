<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%regist_users}}".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $phone 手机号
 * @property string $address 地址
 * @property string $remark 备注
 * @property int $created_at
 */
class RegistUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%regist_users}}';
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
            [['name', 'phone', 'address'], 'required'],
            [['remark'], 'string'],
            [['created_at','updated_at'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'phone' => '手机号',
            'address' => '地址',
            'remark' => '备注',
            'created_at' => 'Created At',
        ];
    }
}
