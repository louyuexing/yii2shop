<?php

namespace backend\controllers;

use backend\models\OrderGoods;
use frontend\models\Order;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $order=Order::find()->all();

        return $this->render('index',['order'=>$order]);
    }
    public function actionUpdate($id){
        $order=Order::findOne(['id'=>$id]);
        if($order->status==1){
            $order->status=2;
        }else{
            $order->status=1;
        }

        $order->save();
        return $this->redirect(['order/index']);
    }

    public function  actionInfo($id){
        $result=\frontend\models\OrderGoods::findAll(['order_id'=>$id]);

        return $this->render('info',['result'=>$result]);
    }


}
