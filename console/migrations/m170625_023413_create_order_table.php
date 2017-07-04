<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170625_023413_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('用户id'),
            'name'=>$this->string()->comment('收货人'),
            'province'=>$this->string(20)->comment('省'),
            'city'=>$this->string(20)->comment('市'),
            'area'=>$this->string(20)->comment('县区'),
            'address'=>$this->string(200)->comment('详细地址'),
            'tel'=>$this->string()->comment('电话号码'),
            'delivery_id'=>$this->integer()->comment('配送方式'),
            'delivery_name'=>$this->string()->comment('配送方式名称'),
            'delivery_price'=>$this->decimal()->comment('配送价格'),
            'payment_id'=>$this->integer()->comment('支付方式id'),
            'payment_name'=>$this->string()->comment('支付方式名称'),
            'total'=>$this->decimal()->comment('订单金额'),
            'status'=>$this->integer()->comment('d订单状态'),
            'trade_no'=>$this->string()->comment('第三方交易号'),
            'create_time'=>$this->integer()->comment('创建时间')




        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
