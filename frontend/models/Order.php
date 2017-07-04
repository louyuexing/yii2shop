<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public  static $delivery=[
        ['delivery_id'=>1,'delivery_name'=>'平邮','delivery_price'=>10],
        ['delivery_id'=>2,'delivery_name'=>'特快专递','delivery_price'=>40],
        ['delivery_id'=>3,'delivery_name'=>'加急快递送货上门','delivery_price'=>40],

        ['delivery_id'=>4,'delivery_name'=>'普通快递送货上门','delivery_price'=>10],
    ];



    public  static $payment=[

        ['payment_id'=>1,'payment_name'=>'邮局汇款','intro'=>'通过快钱平台收款 汇款后1-3个工作日到账'],

        ['payment_id'=>2,'payment_name'=>'上门自提','intro'=>'自提时付款，支持现金、POS刷卡、支票支付'],
        ['payment_id'=>3,'payment_name'=>'货到付款','intro'=>'送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        ['payment_id'=>4,'payment_name'=>'在线支付','intro'=>'即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
    ];

    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name', 'tel', 'delivery_name', 'payment_name', 'trade_no'], 'string', 'max' => 255],
            [['province', 'city', 'area'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'name' => 'Name',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'tel' => 'Tel',
            'delivery_id' => 'Delivery ID',
            'delivery_name' => 'Delivery Name',
            'delivery_price' => 'Delivery Price',
            'payment_id' => 'Payment ID',
            'payment_name' => 'Payment Name',
            'total' => 'Total',
            'status' => 'Status',
            'trade_no' => 'Trade No',
            'create_time' => 'Create Time',
        ];
    }
}
