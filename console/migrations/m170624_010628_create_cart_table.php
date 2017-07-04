<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170624_010628_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer()->comment('用户id'),
            'good_id'=>$this->integer()->comment('商品id'),
            'amount'=>$this->integer()->comment('商品数量')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
