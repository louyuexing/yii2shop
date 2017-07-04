<?php
namespace  frontend\models;
use yii\base\Model;

class UpdateInfoForm extends Model{
    public $username;
    public $email;
    public $tel;

    public function rules(){
        return [
           [['oldpassword','newpassword','password'],'required'],
           ['oldpassword','validateP'],
            ['password','compare','compareAttribute'=>'newpassword','message'=>'两次密码NO一致'],


        ];
    }

}