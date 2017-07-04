<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsIntro;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\data\Pagination;
use yii\web\Request;


class InfoController extends \yii\web\Controller
{


    public $layout='info';

     public function actionInfo($id){
         $good=Goods::findOne(['id'=>$id]);

         return $this->render('info',['good'=>$good,'id'=>$id]);
     }
}
