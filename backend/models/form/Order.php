<?php

namespace backend\models\form;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $order_number 订单号
 * @property int $uid 用户表主键id
 * @property int $car_id 车辆表id
 * @property string $reservation_time 预约时间
 * @property string $price 价格
 * @property string $car_rental_fee 租车费用
 * @property string $deposit 押金
 * @property string $insurance_expenses 保险费用
 * @property string $total_cost 总费用
 * @property int $status 订单状态 1用车中2已完成3已取消
 * @property int $deposit_status 押金状态 1无押金2待退还
 * @property int $extraction_method 取车方式 1到店自取2送车上门
 * @property int $created_at 下单时间
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'car_id'], 'required'],
            [['uid', 'car_id', 'status', 'deposit_status', 'extraction_method', 'created_at'], 'integer'],
            [['reservation_time'], 'safe'],
            [['price', 'car_rental_fee', 'deposit', 'insurance_expenses', 'total_cost'], 'number'],
            [['order_number'], 'string', 'max' => 17],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_number' => '订单号',
            'uid' => '用户表主键id',
            'car_id' => '车辆表id',
            'reservation_time' => '预约时间',
            'price' => '价格',
            'car_rental_fee' => '租车费用',
            'deposit' => '押金',
            'insurance_expenses' => '保险费用',
            'total_cost' => '总费用',
            'status' => '订单状态',// 1用车中2已完成3已取消
            'deposit_status' => '押金状态',// 1无押金2待退还
            'extraction_method' => '取车方式 ',//1到店自取2送车上门
            'created_at' => '下单时间',
        ];
    }
}
