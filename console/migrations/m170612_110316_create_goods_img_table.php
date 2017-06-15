<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_img`.
 */
class m170612_110316_create_goods_img_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_img', [
            'good_id' => $this->primaryKey(),
            'img'=>$this->string()

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_img');
    }
}
