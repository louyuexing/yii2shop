<?php

namespace backend\controllers;

use backend\models\UpdateForm;
use backend\models\User;
use backend\models\UserForm;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(\Yii::$app->user->isGuest){
            \Yii::$app->session->setFlash('danger','未登录请登录');
        return $this->redirect(['user/login']);
    }else{
            $result=User::find()->all();
            return $this->render('index',['result'=>$result]);
        }
    }

    public function actionAdd(){
        $model=new User();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);

                $model->save(false);
                \Yii::$app->session->setFlash('success','注册成功');
              return  $this->redirect(['user/login']);
            }else{
                var_dump($model->getErrors(),'333');exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionLogin(){
        $model=new UserForm();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $user=User::findOne(['username'=>$model->username]);
                $user->last_login_ip=$request->getUserIP();
                $user->last_login_time=time();
                $user->auth_key=\Yii::$app->security->generateRandomString();
                $user->save();
                \Yii::$app->session->setFlash('success','登录成功');
                return $this->redirect(['user/index']);
            }else{
                $error=($model->getErrors());
                \Yii::$app->session->setFlash('warning',$error['username'][0]);
                return $this->redirect(['user/login']);
            }
        }
        return $this->render('login',['model'=>$model]);
    }
     public function actionLoginOut(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出成功');
        return $this->redirect(['user/login']);
     }
     public function actionDelete($id){
         User::findOne(['id'=>$id])->delete();
         \Yii::$app->session->setFlash('success','删除成功');
         return $this->redirect(['user/index']);
     }
     public function actionUpdate($id){
         $model=User::findOne(['id'=>$id]);
         $request=new Request();
         $user=new UpdateForm();
         $user->username=$model->username;
         if($request->isPost){
             $user->load($request->post());
             if($user->validate()){
              $model->load($request->post());
              $model->password_hash=\Yii::$app->security->generatePasswordHash($user->newpassword);
              $model->save();
                 \Yii::$app->session->setFlash('success','修改成功');
                 return $this->redirect(['user/index']);

             }else{
                 $error=($user->getErrors());
                 \Yii::$app->session->setFlash('warning',$error['username'][0]);

             }
         }
         return $this->render('update',['model'=>$model,'user'=>$user]);
     }
}
