<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends Controller
{
    public function actionIndex()
    {   $model=new Brand();
        $result=$model->find()->all();
        return $this->render('index',['result'=>$result]);
    }
    public function actionAdd(){
        $model=new Brand();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                     $fileName='/image/brand/'.uniqid().'.'.$model->imgFile->extension;
                     $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                     $model->logo=$fileName;
                }
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }

        }
        return $this->render('add',['model'=>$model]);
    }

    public function actionUpdate($id){
        $model=Brand::findOne(['id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
                if($model->imgFile){
                    $fileName='/image/brand/'.uniqid().'.'.$model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
                    $model->logo=$fileName;
                }
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['brand/index']);
            }

        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        $model=new Brand();
        if($model->findOne(['id'=>$id])->delete()){
            return $this->redirect(['brand/index']);
            \Yii::$app->session->setFlash('danger','删除成功');
        }else{

        }

    }

}
