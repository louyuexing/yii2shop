<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\GoodsImg;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsImgController extends \yii\web\Controller
{
    public function behaviors(){
        return[
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','img']
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImg($id){
        $model=new GoodsImg();
        $request=new Request();
        if($request->isPost){
            $file =UploadedFile::getInstances($model, 'file');
//            $path='upload/'.date("YmdH",time()).'/';
            foreach ($file as $key=> $fl) {
                $filename='/upload/goodsimg/' .$key.time() .$fl->baseName. '.' . $fl->extension;
                $fl->saveAs(\Yii::getAlias('@webroot').'/upload/goodsimg/' .$key.time() .$fl->baseName. '.' . $fl->extension);
                $model->good_id=$id;
                $model->img=$filename;
                $model->save();
            }

        }

        return $this->render('img',['model'=>$model]);
    }


}
