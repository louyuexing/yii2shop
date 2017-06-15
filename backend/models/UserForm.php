<?php
namespace  backend\models;
use yii\base\Model;

class UserForm extends Model{
    public $password_hash;
    public $username;
    public $newpassword;
    public $oldpassword;
    public $repassword;
    public $password;
    public $email;
    public $status;
    public $rememberme;
    public function rules(){
        return [
            [['username','password_hash'],'required'],
            ['username','validateUsername'],
            ['rememberme','boolean'],
            ['oldpassword','compare','compareAttribute'=>'newpassword','message'=>'两次密码不一致']
        ];
    }
    public function attributeLabels(){
        return [
            'username'=>'用户名',
            'password_hash'=>'密码'
        ];
    }
    public function validateUsername(){
      $user=User::findOne(['username'=>$this->username]);

      if($user!=null){
           if(\Yii::$app->security->validatePassword($this->password_hash,$user->password_hash)){

               $duration=$this->rememberme?7*60:0;
                  \Yii::$app->user->login($user,$duration);

           }else{
            return  $this->addError('username','用户名hui密码错误');
           }
      }else{
        return  $this->addError('username','用户名或密码错误');
      }
    }
}