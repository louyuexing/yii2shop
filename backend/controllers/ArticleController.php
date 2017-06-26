<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    public function behaviors(){
        return[
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','update','delete','find-one']
            ]
        ];
    }

    public function actionIndex()
    {    $result=Article::find()->all();
        return $this->render('index',['result'=>$result]);
    }
    public function actionAdd(){
        $model=new Article();
        $modeld=new ArticleDetail();
        $result=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save();
                $res=$request->post();
                $modeld->content=$res["Article"]["content"];
                $modeld->article_id=$model->id;
                $modeld->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }

    public function actionUpdate($id){
//        $model=Article::findOne(['id'=>$id]);
//        $result=ArticleCategory::find()->all();
//        $request=new Request();
//        if($request->isPost){
//            $model->load($request->post());
//            if($model->validate()){
//                $model->create_time=time();
//
//                $model->save();
//
//                \Yii::$app->session->setFlash('success','添加成功');
//                return $this->redirect(['article/index']);
//            }else{
//                var_dump($model->getErrors());exit;
//            }
//        }
//        return $this->render('add',['model'=>$model,'result'=>$result]);





        $model=Article::findOne(['id'=>$id]);
        $modeld=ArticleDetail::findOne(['article_id'=>$id]);
        $model->content=$modeld->content;
        $result=ArticleCategory::find()->all();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->create_time=time();
                $model->save();
                $res=$request->post();
                $modeld->content=$res["Article"]["content"];
                $modeld->article_id=$model->id;
                $modeld->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }

    public function actionDelete($id){
        Article::findOne(['id'=>$id])->delete();
        return $this->redirect(['article/index']);
    }
    public function actionFindone($id){
        $result=ArticleDetail::findOne(['article_id'=>$id]);
        $total=Article::findOne(['id'=>$id]);
        $model=new Article();
        return $this->render('ainfo',['model'=>$model,'result'=>$result,'total'=>$total]);
    }

}
