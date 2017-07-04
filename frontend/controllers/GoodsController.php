<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsIntro;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\data\Pagination;
use yii\web\Request;


class GoodsController extends \yii\web\Controller
{
    public $path='D:/phpStudy/WWW/yii2shop/backend/web';


    public $layout='goods';

     public function actionIndex(){
         $query=Goods::find();
         $total=$query->count();
         $page=new Pagination(['totalCount'=>$total,'defaultPageSize'=>4]);
//        $cates=$query->offset($page->offset)->limit($page->limit)->all();
//        return $this->render('index',['cates'=>$cates,'page'=>$page]);
//        limit 0,2  offset0 limit2  第一页，从0开始获取2条数据
         $cates = $query->offset($page->offset)->limit($page->limit)->all();
//        var_dump($cates);exit;
         return $this->render('index',['cates'=>$cates,'page'=>$page]);
     }




}
