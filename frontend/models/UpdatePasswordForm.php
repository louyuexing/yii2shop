<?php
namespace  frontend\models;
use yii\base\Model;

class UpdatePasswordForm extends Model{
    public $username;
    public $newpassword;
    public $oldpassword;
    public $password;

    public function rules(){
        return [
           [['oldpassword','newpassword','password'],'required'],
           ['oldpassword','validateP'],
            ['password','compare','compareAttribute'=>'newpassword','message'=>'两次密码NO一致'],


        ];
    }
    public function attributeLabels(){
        return [
            'username'=>'用户名',
            'oldpassword'=>'旧密码',
            'newpassword'=>'新密码',
            'password'=>' 确认密码',
        ];
    }
    public function validateP(){

      $user=Member::findOne(['username'=>$this->username]);

      if($user!=null){
           if(\Yii::$app->security->validatePassword($this->oldpassword,$user->password_hash)){
               \Yii::$app->user->login($user);
           }else{
               $this->addError('oldpassword','旧密码错误');
               return false;
           }
      }else{
           $this->addError('oldpassword','旧密码-错误');
          return false;
      }
    }
}