<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsIntro;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Request;


class CartController extends \yii\web\Controller
{


    public $layout='top';

     public function actionIndex(){

         $amount = \Yii::$app->request->post('amount');
         $good_id = \Yii::$app->request->post('good_id');
         if(\Yii::$app->user->isGuest){

             $good=Goods::findOne(['id'=>$good_id]);
             if($good==null){
                 throw new NotFoundHttpException('没有找到');
             }

             $cookies = \Yii::$app->request->cookies;
             $cookie=$cookies->get('cart');
             if($cookie==null){
                 $cart=[];
             }else{
                 $cart=unserialize($cookie->value);
             }


             if(key_exists($good_id,$cart)){
                 $cart[$good_id]+=$amount;
             }else{
                 $cart[$good_id]=$amount;
             }
             $cookies = \Yii::$app->response->cookies;
             $cookie = new Cookie([
                 'name' => 'cart', 'value' => serialize($cart)
             ]);
             $cookies->add($cookie);

             return $this->redirect(['cart/cart']);
//             var_dump(\Yii::$app->user->id);exit;
         }else{
             $user_id=\Yii::$app->user->id;
            if($good_id!=null){
                $cart=Cart::find()->where(['user_id'=>$user_id,'good_id'=>$good_id])->all();

                if($cart==null){
                    $cart=new Cart();
                    $cart->good_id=$good_id;
                    $cart->amount=$amount;
                    $cart->user_id=$user_id;
                    $cart->save();

                }else{
                    $cart[0]->amount+=$amount;
                    $cart[0]->save();
                }

            }

            $cookies=\Yii::$app->request->cookies;
            $cookie=$cookies->get('cart');

            if($cookie!=null){
                $result=unserialize($cookie->value);

                foreach ($result as $key=>$row){

                    $cart=Cart::find()->where(['user_id'=>$user_id,'good_id'=>$key])->all();
                    var_dump($key,$row,$cart);
                    if($cart==null){
                        $cart=new Cart();
                        $cart->good_id=$key;
                        $cart->amount=$row;
                        $cart->user_id=$user_id;
                        $cart->save();

//                        var_dump($cart[0]->save(),90);exit;
                    }else{

                        $cart[0]->amount+=$row;
                        $cart[0]->save();
//                        var_dump($cart[0]->amount,100);exit;
                    }
                }

                $cookies=\Yii::$app->response->cookies;
                $cookies->remove('cart');

            }
         }

        return $this->redirect(['cart/cart']);
     }

     public function actionCart()
     {
         if(\Yii::$app->user->isGuest){

             $cookies = \Yii::$app->request->cookies;
             $cookie = $cookies->get('cart');
             if($cookie!=null){
                 $result = unserialize($cookie->value);
                 $goods = [];
                 foreach ($result as $key => $row) {
                     $good = Goods::findOne(['id' => $key])->attributes;
                     $good['amount'] = $row;
                     $goods[] = $good;
                 }
             }
             else {
                 $goods = [];
             }
//             var_dump($cookie,$goods,\Yii::$app->user->id);exit;
         }else{

             $user_id=\Yii::$app->user->id;
             $cookies = \Yii::$app->request->cookies;
             $cookie = $cookies->get('cart');
//             var_dump($cookie,\Yii::$app->user->id);exit;
            if($cookie!=null){
                $result=unserialize($cookie->value);
                foreach ($result as $key=>$row){
                    $cart=Cart::find()->where(['user_id'=>$user_id,'good_id'=>$key])->all();
                    if($cart==null){
                        $cart=new Cart();
                        $cart->good_id=$key;
                        $cart->amount=$row;
                        $cart->user_id=$user_id;
                        $cart->save();

                    }else{

                        $cart[0]->amount+=$row;
                        $cart[0]->save();



                    }
                }

                $cookies=\Yii::$app->response->cookies;
                $cookies->remove('cart');
            }


            $goods=[];
            $result=Cart::findAll(['user_id'=>$user_id]);

            foreach ($result as $row){

                $good=Goods::findOne(['id'=>$row->good_id])->attributes;

                $good['amount']=$row->amount;
                $goods[]=$good;

            }
//             var_dump($goods,\Yii::$app->user->id);exit;
         }


         return $this->render('index', ['goods' => $goods]);

     }

     public function actionUpdate(){
         $good_id=\Yii::$app->request->post('good_id');
         $amount=\Yii::$app->request->post('amount');

         if(\Yii::$app->user->isGuest){
             if($amount==0){
                 $cookies=\Yii::$app->request->cookies;
                 $cookie=$cookies->get('cart');
                 $rs= unserialize($cookie->value);
                 $result=[];
                 foreach ($rs as $key => $row){
                     if($key==$good_id){
                         unset($row,$key);

                     }else{
                         $result[$key]=$row;
                     }

                 }

             }else{
                 $cookies=\Yii::$app->request->cookies;
                 $cookie=$cookies->get('cart');
                 $result = unserialize($cookie->value);
                 foreach ($result as $key => $row){
                     if($key==$good_id){
                         unset($row,$key);
                         $result[$good_id]=$amount;
                     }
                 }
             }


             $cookie=new Cookie([
                 'name'=>'cart',
                 'value'=>serialize($result)
             ]);
             $cookies=\Yii::$app->response->cookies;
             $cookies->add($cookie);
             $good=Goods::findOne(['id'=>$good_id]);
             $price=($good->shop_price)*$amount;
             $row=[];
             $row['price']=$price;
             $row['amount']=$good->stock;
             return Json::encode($row);
         }else{
             if($amount==0){
                 $user_id = \Yii::$app->user->id;
                 $good= Cart::find()->where(['user_id' => $user_id, 'good_id' => $good_id])->all();
                 $good[0]->delete();
             }else {
                 $user_id = \Yii::$app->user->id;
                 $good = Cart::find()->where(['user_id' => $user_id, 'good_id' => $good_id])->all();
                 $good[0]->amount = $amount;
                 var_dump($good[0]->amount);
                 $good[0]->save();
             }

             $good=Goods::findOne(['id'=>$good_id]);
             $price=($good->shop_price)*$amount;
             $row=[];
             $row['price']=$price;
             $row['amount']=$good->stock;
             return Json::encode($row);

         }



     }

     public function actionOrder(){
         $model=new Order();
         $result=Cart::findAll(['user_id'=>\Yii::$app->user->id]);
         $goods=[];
         foreach ($result as $row){
            $good= Goods::findOne(['id'=>$row->good_id])->attributes;
            $good['amount']=$row->amount;
            $goods[]=$good;
         }

         $address_all=Address::findAll(['user_id'=>\Yii::$app->user->id]);

         return $this->render('order',['model'=>$model,'goods'=>$goods,'address_all'=>$address_all]);
     }


     public function actionCreate(){
         $model=new Order();
         if(!$_POST['address_id']){
             throw new  NotFoundHttpException('没有收货地址');
         }

         $address_id=$_POST['address_id'];
         $model->member_id=\Yii::$app->user->id;
         $model->delivery_id=$delivery=$_POST['delivery'];
         $model->payment_id=$pay=$_POST['pay'];
         $model->total=$_POST['total'];
         $address=Address::findOne(['id'=>$address_id]);
         $addre=new Address();

            $model->name=$address->name;
            $model->province=$addre->Addre($address->provinces);
            $model->city=$addre->Addre($address->city);
            $model->area=$addre->Addre($address->area);
            $model->address=$address->addressinfo;
            $model->tel=$address->phone;

         $deliveryes=Order::$delivery;

         foreach ($deliveryes as $row){
             if($row['delivery_id']==$delivery){
                 $model->delivery_name=$row['delivery_name'];
                 $model->delivery_price=$row['delivery_price'];
             }

         }
         $payments=Order::$payment;
         foreach ($payments as $payment){
             if($payment['payment_id']==$pay){
                 $model->payment_name=$payment['payment_name'];
             }
         }

        if($pay==3){
        $model->status=2;
        }else {
            $model->status=1;
        }
        $model->create_time=time();
        $model->save();



        $order_goods=new OrderGoods();
         $carts=Cart::findAll(['user_id'=>\Yii::$app->user->id]);
         foreach ($carts as $cart){
             $good=Goods::findOne(['id'=>$cart->good_id]);
             $good->stock-=$cart->amount;
             $order_goods->order_id=$model->id;
            $order_goods->goods_id=$good->id;
            $order_goods->goods_name=$good->name;
            $order_goods->logo=$good->logo;
            $order_goods->price=$good->shop_price;
             $order_goods->amount=$cart->amount;
             $order_goods->total=$cart->amount*$good->shop_price;
             $order_goods->insert();
             $cart->delete();
             $order_goods->save();
             $good->save();
         }

        var_dump($model->save(),$order_goods->save(),$model->getErrors());

     }

     public function actionOrderGoods(){
         $carts=Cart::findAll(['user_id'=>\Yii::$app->user->id]);
         $goods=[];
         foreach ($carts as $cart){
             $good=Goods::findOne(['id'=>$cart->good_id])->attributes;
             $good['amount']=$cart->amount;
             $goods[]=$good;
         }
     }
}
