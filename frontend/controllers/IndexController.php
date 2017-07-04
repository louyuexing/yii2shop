<?php

namespace frontend\controllers;

use backend\models\GoodsCategory;
use frontend\models\Address;
use yii\web\Request;

class IndexController extends \yii\web\Controller
{
    public $layout='index';

    public function actionIndex(){

        $result = GoodsCategory::findAll(['parent_id'=>0]);
        return $this->render('index',['result'=>$result]);
    }
}
