<?php

namespace backend\controllers;

use backend\components\RbacFilter;
use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{
    public function behaviors(){
        return[
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['info']
            ]
        ];
    }
    public function actionInfo($id){
        $goodsintro=GoodsIntro::findOne(['parent_id'=>$id]);
        return $this->render('info',['goodsintro'=>$goodsintro]);
    }

}
