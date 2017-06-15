<?php
namespace backend\models;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends Model{
    public $name;
    public $description;
    public $permissions=[];
    public function rules(){
        return [
            [['name','description'],'required'],
            ['permissions','safe']

        ];
    }

    public function attributeLabels(){
        return [
            'name'=>'名称',
            'description'=>'描述',
            'permissions'=>'权限'
        ];
    }


    public function loadrole(){
      $authManager= \Yii::$app->authManager;
      if(\Yii::$app->authManager->getRole($this->name)){
          $this->addError('name','绝世已经存在');
      }else{
          $role=$authManager->createRole($this->name);
          $role->description=$this->description;
          if($authManager->add($role)){
                 if($this->permissions!=null){
                     foreach ($this->permissions as $permissionName){
                         $permission=$authManager->getPermission($permissionName);
                         $authManager->addChild($role,$permission);

                     }
                 }

              return true;
          }
      }
      return false;
    }

    public function loadrolename($name){
        $role=\Yii::$app->authManager->getRole($name);

        $this->name=$role->name;
        $this->description=$role->description;
        $result=\Yii::$app->authManager->getPermissionsByRole($name);
        foreach ($result as $row){
           $this->permissions[]=$row->name;
        }


    }
        public static function getPermission()
        {
            $authManager = \Yii::$app->authManager;
            return ArrayHelper::map($authManager->getPermissions(),'name','description');//获取所有权限
        }


        public function loadupdaterole($name)
        {
          $authManager=\Yii::$app->authManager;
          $role=$authManager->getRole($name);

          $role->name=$this->name;
          $role->description=$this->description;

          if($this->name!=$name && $authManager->getRole($this->name)){
              $this->addError('name','角色已存在');
          }else{
             if($authManager->update($name,$role)){
                 $authManager->removeChildren($role);
                 if($this->permissions!=null){
                     foreach ($this->permissions as $permissionName) {
                         $permission = $authManager->getPermission($permissionName);
                         if($permission) $authManager->addChild($role,$permission);
                     }
                 }

                 return true;
             }
          }
          return false;
        }
}