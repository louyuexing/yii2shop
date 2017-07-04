<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170619_025749_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
             'username'=>$this->string(10)->comment('用户名'),
            'auth_key'=>$this->string(),
            'password_hash'=>$this->string()->comment('密码'),
            'email'=>$this->string()->comment('邮箱'),
            'tel'=>$this->integer(11)->comment('电话'),
            'last_login_time'=>$this->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->integer()->comment('最后登录IP'),
            'status'=>$this->integer()->comment('状态'),
            'created_at'=>$this->integer()->comment('添加时间'),
            'update_at'=>$this->integer()->comment('修改事件')

//            id primaryKey
//        username varchar﴾50﴿ 用户名
//        auth_key varchar﴾32﴿
//        password_hash varchar﴾100﴿ 密码（密文）
//        email varchar﴾100﴿ 邮箱
//        tel char﴾11﴿ 电话
//        last_login_time int 最后登录时间
//        last_login_ip int 最后登录ip
//        status int﴾1﴿ 状态（1正常，0删除）
//        created_at int 添加时间
//        updated_at int 修改时间

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
