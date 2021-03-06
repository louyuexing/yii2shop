<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

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
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */

    public $password;
    public $repassword;
    public $code;
    public $smscode;

    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tel', 'last_login_time', 'status', 'created_at', 'update_at'], 'integer'],
            [['username'], 'string', 'max' => 10],
            [['auth_key', 'password_hash', 'email'], 'string', 'max' => 255],
            ['password','compare','compareAttribute'=>'repassword','message'=>'两次输入不一致'],
            [['username','tel','email'],'unique'],
            [['password','repassword','username','tel','smscode'],'required'],
            ['email','email'],
           ['code','captcha','captchaAction'=>'api/captcha'],
            ['smscode','validateCode']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名:',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => '邮箱:',
            'tel' => '电话:',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'status' => '状态',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'password'=>'密码:',
            'repassword'=>'确认密码:',
            'code'=>'验证码:',
            'smscode'=>'验证码:'

        ];
    }

    public function validateCode(){
        $code=Yii::$app->cache->get($this->tel);
        if($code==false||$code!=$this->smscode){
            return $this->addError('smscode','手机验证码错误');
        }
    }



   public function beforeSave($insert){
        if($insert){
            $this->created_at=time();
            $this->auth_key=Yii::$app->security->generateRandomString();
        }
        if($this->password){
            $this->password_hash=Yii::$app->security->generatePasswordHash($this->password);
        }
       return parent::beforeSave($insert);

   }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.

         return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.

    }
}
