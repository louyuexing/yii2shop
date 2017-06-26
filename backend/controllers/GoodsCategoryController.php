<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\GoodsCategory;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
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
    {    $result=GoodsCategory::find()->orderBy(['tree'=>'asc','lft'=>'asc'])->all();
        return $this->render('index',['result'=>$result]);
    }
    public function actionAdd(){
        $model=new GoodsCategory();
        $request=new Request();
         if($request->isPost){
             $model->load($request->post());
             if($model->validate()){
                 if($model->parent_id==0){
                      $model->makeRoot();
                 }else{
                     $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                     $model->prependTo($parent);
                 }
                 \Yii::$app->session->setFlash('success','添加成功');
                 return $this->redirect(['goods-category/index']);
             }
         }


//        $options=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');
        $result=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }


    public function actionUpdate($id){
        $model=GoodsCategory::findOne(['id'=>$id]);
        if($model==null){
            throw new NotFoundHttpException('没有找到ID');
        }
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    if($model->getOldAttribute('parent_id')==0){
                        $model->save();
                    }else{
                        $model->makeRoot();
                    }

                }else{

                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                }
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods-category/index']);
            }
        }


//        $options=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');
        $result=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }

    public function actionDelete($id){
        $result=GoodsCategory::findAll(['parent_id'=>$id]);
        if($result==null){
           GoodsCategory::findOne(['id'=>$id])->delete();
            \Yii::$app->getSession()->setFlash('success', '删除成功');
            return $this->redirect(['goods-category/index']);
        }else{
            \Yii::$app->getSession()->setFlash('danger', '不能删除有子类的分类');

            return $this->redirect(['goods-category/index']);
        }
    }









    public function actionTest(){
//        $test=new GoodsCategory();
//        $test->name='家用电器';
//        $test->parent_id=0;
//        $test->makeRoot();//将当前分类设置为一级分类
        //创建二级分类
//          $parent=GoodsCategory::findOne(['id'=>1]);
//          $test=new GoodsCategory();
//          $test->name='小家电';
//          $test->parent_id=1;
//          $test->prependTo($parent);

        //获取一级分类
//        $roots = GoodsCategory::find()->roots()->all();
//        var_dump($roots);
//        $leaves =GoodsCategory::find()->leaves()->all();
//        var_dump($leaves);
//        $countries = GoodsCategory::findOne(['name' => '家用电器']);
//        $leaves = $countries->leaves()->all();
//        var_dump($leaves);


        $result=json_encode(GoodsCategory::find()->asArray()->all());

        return $this->renderPartial('test',['result'=>$result]);

    }
}
