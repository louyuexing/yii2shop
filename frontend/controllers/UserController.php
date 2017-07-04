<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Request;
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Flc\Alidayu\Requests\IRequest;

class UserController extends \yii\web\Controller
{
    public $layout='login';

    public function actionIndex(){

    if(\Yii::$app->user->isGuest){

        return $this->redirect(['user/login']);
    }else{

        return $this->render('index');
    }

    }

    public function actionRegister(){
        $model=new Member();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $model->save(false);
            \Yii::$app->session->setFlash('success','注册成功');
            return $this->redirect(['user/login']);
        }else{
//            var_dump($model->getErrors());exit;
        }
        return $this->render('register',['model'=>$model]);
    }

    public function actionLogin(){
        $model=new LoginForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if ($model->validate()&& $model->loaddate()){

                $user=Member::findOne(['username'=>$model->username]);
                $user->last_login_ip=$request->getUserIP();
                $user->last_login_time=time();
                $user->save(false);
                return $this->redirect(['goods/index']);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('login',['model'=>$model]);
    }

    public function actionLoginOut(){
        \Yii::$app->user->logout();

        return $this->redirect(['user/login']);
    }

    public function actions()
    {
        return [
            'captcha'=>[
                'class'=>'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength'=>4,//验证码最小长度
                'maxLength'=>4,//最大长度
            ]
        ];
    }




    public function actionSms(){
        // 配置信息
        if($_POST['name']==null){
            $name='';
        }else{
            $name=$_POST['name'];
        }
        $tel=$_POST['tel'];

        var_dump($name,$tel);
       $config = [
              'app_key'=> '24480026',
              'app_secret' => '49eabaa8716d172a94deb3a0c20bd9a9',
//            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
//        // 使用方法一
         $client= new Client(new App($config));
          $req = new AlibabaAliqinFcSmsNumSend;
          $code= rand(100000, 999999);
            $req->setRecNum("$tel")
            ->setSmsParam([
                'name'=>$name,
                'code' =>$code])
            ->setSmsFreeSignName('周浩')
            ->setSmsTemplateCode('SMS_71745035');
            $resp = $client->execute($req);
//             $resp=1;
            if($resp){

                \Yii::$app->cache->set($tel,$code,6*60);
                return 'success';
            }else {
                return '发送失败';
            }

            }



            public function actionEmail(){

                    $fff = \Yii::$app->mailer->compose()
                    ->setFrom(['1403047625@qq.com'=>'我看你傻了']) //和上面的from字段相对应  可以只写一个
                    ->setTo('1403047625@qq.com')
                    ->setSubject('2017')
                    ->setTextBody('sdfffffffffffffffffffffffffffff')
                    ->send();
                    var_dump($fff);
            }
}
