<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use crazyfd\qiniu\Qiniu;
use backend\models\Brand;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;

class BrandController extends Controller
{
    public function behaviors(){
        return[
           'rbac'=>[
               'class'=>RbacFilter::className(),
                'only'=>['index','add','update','delete']
              ]
        ];

    }







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
//            $model->imgFile=UploadedFile::getInstance($model,'imgFile');

            if($model->validate()){
//                if($model->imgFile){
//                     $fileName='/image/brand/'.uniqid().'.'.$model->imgFile->extension;
//                     $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
//                     $model->logo=$fileName;
//                }
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

//            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
            if($model->validate()){
//                if($model->imgFile){
//                    $fileName='/image/brand/'.uniqid().'.'.$model->imgFile->extension;
//                    $model->imgFile->saveAs(\Yii::getAlias('@webroot').$fileName,false);
//                    $model->logo=$fileName;
//                }
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
    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filehash = sha1(uniqid() . time());
//                    $p1 = substr($filehash, 0, 2);
//                    $p2 = substr($filehash, 2, 2);
//                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
//                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png','jpeg'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $imgUrl=$action->getWebUrl();
                    $ak = '51hXH-b0k1cleObZ_IT1EBdGkGrkw2OjssWllCjv';
                    $sk = 'ue6vEeMhinc4uI7Ua2eye8lPky1P84F6bJixWO7C';
                    $domain = 'http://or9sy0xsk.bkt.clouddn.com/';
                    $bucket = 'yii2study';

                    $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
                    $qiniu->uploadFile(\Yii::getAlias('@webroot').$imgUrl,$imgUrl);

                    $url=$qiniu->getLink($imgUrl);
                    $action->output['fileUrl'] =$url;


//                    $action->output['fileUrl'] = $action->getWebUrl();
//                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
//                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
//                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }
    public function actionTest(){
        $ak = '51hXH-b0k1cleObZ_IT1EBdGkGrkw2OjssWllCjv';
        $sk = 'ue6vEeMhinc4uI7Ua2eye8lPky1P84F6bJixWO7C';
        $domain = 'http://or9sy0xsk.bkt.clouddn.com/';
        $bucket = 'yii2study';

        $qiniu = new Qiniu($ak, $sk,$domain, $bucket);
        $key = 'test.jpg';
        $imgFile=\Yii::getAlias('@webroot'.'/upload/test.jpg');
        $re=$qiniu->uploadFile($imgFile,$key);
        $url = $qiniu->getLink($key);
        var_dump($re,$url);
    }
}
