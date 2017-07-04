<?php

namespace frontend\controllers;

use frontend\models\AddForm;
use frontend\models\Address;
use frontend\models\Locations;
use yii\helpers\Json;
use yii\web\Request;

class AddressController extends \yii\web\Controller
{
    public $layout='address';

    public function actionIndex(){
        $model=new Address();
        $user_id=\Yii::$app->user->id;
        $result=Address::findAll(['user_id'=>$user_id]);

        $request=new Request();

        if($request->isPost){
            $model->load($request->post());

            if($model->validate()){
                 $model->user_id=\Yii::$app->user->id;

                $model->save();

                return $this->redirect(['address/add']);

            }
        }
        return $this->render('index',['model'=>$model,'result'=>$result]);
    }

    public function actionDelete($id){
        Address::findOne(['id'=>$id])->delete();
        return $this->redirect(['address/index']);
    }


    public function actionDefault($id){
        $addrees=Address::findOne(['id'=>$id]);
        if($addrees->status){
            $addrees->status=0;
            $addrees->save();
            return $this->redirect(['address/index']);
        }else{
            $addrees->status=1;
            $addrees->save();
            $addreesAll=Address::findAll(['status'=>0]);
            foreach ($addreesAll as $addreesone) {
                $addreesone->status = 0;
                $addreesone->save();
            }
            return $this->redirect(['address/index']);
        }
    }

    public function actionUpdate($id){
        $model=Address::findOne(['id'=>$id]);
        $request=new Request();
        $result=Address::find()->all();
        if($request->isPost){
            $model->load($request->post());

            if($model->validate()){

                $model->save();

                return $this->redirect(['address/index']);

            }
        }
        return $this->render('index',['model'=>$model,'result'=>$result]);
    }


    public function actionFindAddress(){
        $parent_id=$_GET['parent_id'];
        $result=Locations::findAll(['parent_id'=>$parent_id]);
        return  Json::encode($result);
    }

}
