<?php

namespace backend\controllers;

use backend\models\ArticleDetail;
use yii\web\Controller;
use yii\web\Request;

class Article_detailController extends Controller
{
    public function actionFindD($id)
    {
        return $result=ArticleDetail::findOne(['article_id'=>$id]);
    }
    public function actionAdd(){
        $model=new ArticleDetail();
        $result=ArticleDetail::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }

}
