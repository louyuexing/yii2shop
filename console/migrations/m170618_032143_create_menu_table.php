<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170618_032143_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer(10)->comment('父类ID'),
            'label'=>$this->string(20)->comment('名称'),
            'url'=>$this->string(30)->comment('地址/路由')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
