<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Request;


class RbacController extends \yii\web\Controller
{

    public function actionIndex(){
       $models=\Yii::$app->authManager->getPermissions();
//       var_dump($models);exit;
       return $this->render('index',['models'=>$models]);
    }


    public function actionAddPermission(){
        $model= new PermissionForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->addpermission()){
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['rbac/index']);
            }
        }
        return $this->render('add-permission',['model'=>$model]);
    }
    public function actionUpdatePermission($name){

    }
    public function actionDel($name){
//        var_dump(\Yii::$app->authManager->getPermission($name));exit;
        if(\Yii::$app->authManager->getPermission($name)==null){
            throw  new NotFoundHttpException('没有找到');
        }
        \Yii::$app->authManager->remove(\Yii::$app->authManager->getPermission($name));
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['rbac/index']);
    }
    public function actionEdit($name)
    {
        $authManager = \Yii::$app->authManager;
        $model = new PermissionForm();
        if ($authManager->getPermission($name) == null) {
            throw  new NotFoundHttpException('没有找到');
        }
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
           if($model->loadpermissionname($name)){
               \Yii::$app->session->setFlash('success','修改成功');
               return $this->redirect(['rbac/index']);
           }
        }
        $model->loadpermission($name);
        return $this->render('add-permission', ['model' => $model]);
     }

     public function actionAddRole(){
        $model=new RoleForm();
        $result=\Yii::$app->authManager->getPermissions();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->loadrole()){
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['rbac/role-index']);
            }
        }
        $permissions=ArrayHelper::map($result,'name','description');
        return $this->render('roleadd',['model'=>$model,'permissions'=>$permissions]);
     }




     public function actionRoleIndex(){
         $models= \Yii::$app->authManager->getRoles();

         return $this->render('roleindex',['models'=>$models]);

     }

     public function actionRoleDel($name){
        $role=\Yii::$app->authManager->getRole($name);
       \Yii::$app->authManager->remove($role);
         \Yii::$app->session->setFlash('success','删除成功');
         return $this->redirect(['rbac/role-index']);
     }

     public function actionRoleEdit($name){
       $model=new RoleForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
           if ($model->loadupdaterole($name)){
               \Yii::$app->session->setFlash('success','修改成功');
               return $this->redirect(['rbac/role-index']);
            }
        }
         $model->loadrolename($name);
         return $this->render('roleadd',['model'=>$model]);

     }

}
