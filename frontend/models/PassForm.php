<?php

namespace frontend\models;

use frontend\controllers\UserController;
use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property integer $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $update_at
 */
class PassForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $password;
    public $newpassord;
    public $oldpassword;
    public $username;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','newpassord','oldpassword',],'required'],
          ['']

//            ['code','captcha']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'username' => '用户名:',
            'password'=>'密码:',
             'rememberme'=>'记住密码'
        ];
    }

   public function loaddate(){
        $user=Member::findOne(['username'=>$this->username]);
       if($user!=null){

           if(Yii::$app->security->validatePassword($this->password,$user->password_hash)){

                    $duration=$this->rememberme?7*90:0;
                      Yii::$app->user->login($user,$duration);
               return true;
           }else{
               $this->addError('username','用户名或密码错误');
               return false;
           }
       }else{
         $this->addError('username','用户名或密码错误');
           return false;
       }
   }
}
