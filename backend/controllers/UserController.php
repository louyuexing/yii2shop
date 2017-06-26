<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\UpdateForm;
use backend\models\UpdatePasswordForm;
use backend\models\User;
use backend\models\UserForm;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','index','update'],
            ]
        ];
    }


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
        $model->loadrole();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
//
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->auth_key=\Yii::$app->security->generateRandomString();
                $model->save(false);
                $model->loadrolename();
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
         $model->roleid($id);
         $request=new Request();
         if($request->isPost){
             if($model->validate()){
              $model->load($request->post());
                 $model->role($id);
                 $model->save(false);
                 \Yii::$app->session->setFlash('success','修改成功');
                 return $this->redirect(['user/index']);

             }else{
                 $error=($model->getErrors());

                 var_dump($error);exit;
             }
         }

         return $this->render('update',['model'=>$model]);
     }


     public function actionUpdatePassword($id){
         $user=User::findOne(['id'=>$id]);
         $model=new UpdatePasswordForm();
         $request=new Request();
         if($request->isPost){
             $model->load($request->post());
             $model->username=$user->username;

             if($model->validate()){
                 $user->password_hash=\Yii::$app->security->generatePasswordHash($model->newpassword);
                 $user->save();
                 \Yii::$app->session->setFlash('success','密码修改成功');
                 return $this->redirect(['user/index']);

             }else{
                 $error=($model->getErrors()['oldpassword'][0]);
                \Yii::$app->session->setFlash('danger',$error);
//var_dump($model->getErrors());exit;

             }
         }

         return $this->render('updatep',['model'=>$model]);
     }

     public function actionRePassword($id){
         $user=User::findOne(['id'=>$id]);
         $user->password_hash=\Yii::$app->security->generatePasswordHash(123456);
         $user->save();
         \Yii::$app->session->setFlash('success','重置成功');
         return $this->redirect(['user/index']);
     }
}
