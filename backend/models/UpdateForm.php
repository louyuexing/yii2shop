<?php
namespace  backend\models;
use yii\base\Model;

class UpdateForm extends Model{
    public $password_hash;
    public $username;
    public $newpassword;
    public $oldpassword;
    public $repassword;
    public $password;
    public $email;
    public $status;
    public function rules(){
        return [
            [['repassword','newpassword','newpassword'],'required'],
            ['oldpassword','validatePassword'],
            ['repassword','compare','compareAttribute'=>'newpassword','message'=>'两次密码不一致']
        ];
    }
    public function attributeLabels(){
        return [
            'username'=>'用户名',
            'oldpassword'=>'旧密码'
        ];
    }
    public function validatePassword(){
      $user=User::findOne(['username'=>$this->username]);
      if($user!=null){
           if(\Yii::$app->security->validatePassword($this->oldpassword,$user->password_hash)){
               \Yii::$app->user->login($user);
           }else{
              $this->addError('username','用户名密码错误');
           }
      }else{
          $this->addError('username','用户名或密码错误');
      }
    }
}