<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170621_015815_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment('收货人'),
            'provinces'=>$this->string()->comment('省份'),
            'city'=>$this->string()->comment('市区'),
            'area'=>$this->string()->comment('街道'),
            'addressinfo'=>$this->string()->comment('详细地址'),
            'tel'=>$this->integer()->comment('手机号码'),
            'status'=>$this->integer()->comment('是否为默认地址')

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
