<?php
namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class Article_categoryController extends Controller
{
    public function behaviors(){
        return[
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['index','add','delate','update']
            ]
        ];


    }



    public function actionIndex()
    {   // $model =new ArticleCategory();
  //          $result=$model->find()->all();
          $query=ArticleCategory::find();
          $total=$query->count();
          $page=new Pagination(['totalCount'=>$total,'defaultPageSize'=>3]);
          $cates=$query->offset($page->offset)->limit($page->limit)->all();
          return $this->render('index',['cates'=>$cates,'page'=>$page]);
    }
    public function actionAdd(){
        $model=new ArticleCategory();
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article_category/index']);

            }else{
                var_deup($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id){
        ArticleCategory::findOne(['id'=>$id])->delete();
        return $this->redirect(['article_category/index']);
    }
    public function actionUpdate($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $request= new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['article_category/index']);

            }else{
                var_deup($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }

}
