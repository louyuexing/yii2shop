<?php
namespace backend\models;
use yii\base\Model;

class PermissionForm extends Model{
    public $name;
    public $description;

    public function rules(){
        return [
            [['name','description'],'required'],

        ];
    }

    public function attributeLabels(){
        return [
            'name'=>'名称',
            'description'=>'备注'
        ];
    }
    public function addpermission(){
       $authManager=\Yii::$app->authManager;
       if($authManager->getPermission($this->name)){
           $this->addError('name','权限已经存在');
           return false;
       }
       $permission=$authManager->createPermission($this->name);
       $permission->description=$this->description;
       $authManager->add($permission);
        return true;
    }

    public function loadpermission($name){
        $authManager=\Yii::$app->authManager->getPermission($name);
        $this->name=$authManager->name;
        $this->description=$authManager->description;
        return true;
    }

    public function loadpermissionname($name){
        $authManager=\Yii::$app->authManager;
        if($this->name!=$name){
            if ($authManager->getPermission($this->name)) {
                $this->addError('name', '权限已存在');
                return false;
            }else{
                $authManager=\Yii::$app->authManager->getPermission($name);
                $authManager->name=$this->name;
                $authManager->description=$this->description;
                \Yii::$app->authManager->update($name,$authManager);
                return true;
            }

        }else{
            $authManager=\Yii::$app->authManager->getPermission($name);
            $authManager->name=$this->name;
            $authManager->description=$this->description;
            \Yii::$app->authManager->update($name,$authManager);
            return true;
        }

    }
}