<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\Menu;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class MenuController extends \yii\web\Controller
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
    {
        $result=Menu::find()->orderBy(['tree'=>SORT_ASC,'lft'=>SORT_ASC])->all();
        return $this->render('index',['result'=>$result]);
    }


    public function actionAdd(){
        $model=new Menu(['scenario'=>Menu::SCENARIO_ADD]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    $model->makeRoot();
                }else{
                    $parent=Menu::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                }
                \Yii::$app->session->setFlash('success','添加成功');
//                return $this->redirect(['goods-category/index']);
            }
        }


//        $options=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');
        $result=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Menu::find()->select(['id','parent_id','name'])->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }

    public function actionDelete($id)
    {    $menu=Menu::findOne(['id' => $id]);
        if($menu->parent_id==0){
            throw new NotFoundHttpException('不能删除顶级分类');
            exit;
        }
        $result = Menu::findAll(['parent_id' => $id]);
        if ($result == null) {
            Menu::findOne(['id' => $id])->delete();
            \Yii::$app->getSession()->setFlash('success', '删除成功');
            return $this->redirect(['menu/index']);
        } else {
            \Yii::$app->getSession()->setFlash('danger', '不能删除有子类的分类');

            return $this->redirect(['menu/add']);
        }
    }

    public function actionUpdate($id){
        $model=Menu::findOne(['id'=>$id]);
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

                    $parent=Menu::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                }
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['menu/add']);
            }
        }


//        $options=ArrayHelper::map(GoodsCategory::find()->asArray()->all(),'id','name');
        $result=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],Menu::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result]);
    }
}
