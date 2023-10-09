<?php

namespace backend\models\form;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%cartype}}".
 *
 * @property int $id id
 * @property string $type_name 类别名称
 * @property int $type 类型1品牌2配置
 * @property int $created_at
 * @property int $updated_at
 */
class Cartype extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cartype}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name','type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['type_name'], 'string', 'max' => 255],
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
            'id' => Yii::t('app', 'id'),
            'type_name' => Yii::t('app', '类别名称'),
            'type' => Yii::t('app', '类型'),//1品牌2配置
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
        ];
    }
}
