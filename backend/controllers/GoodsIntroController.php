<?php

namespace backend\controllers;

use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{

    public function actionInfo($id){
        $goodsintro=GoodsIntro::findOne(['parent_id'=>$id]);
        return $this->render('info',['goodsintro'=>$goodsintro]);
    }

}
