<?php

namespace frontend\controllers;



use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\UpdatePasswordForm;
use Flc\Alidayu\App;
use Flc\Alidayu\Client;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;
use yii\web\UploadedFile;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function init(){
       \Yii::$app->response->format=Response::FORMAT_JSON;
        parent::init();
    }
    public function actionTest(){
        return ['name'=>'li'];
    }

    public function actionRegister(){
        $model=new Member();
        $request=\Yii::$app->request;
        if($request->isPost){
           $model->load($request->post());
           if($model->validate()){
               $model->save(false);
               return ['success'=>'true','errorMsg'=>'','result'=>$model->toArray()];

           } return ['success'=>'false','errorMsg'=>$model->getErrors(),'result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }

    public function actionLogin(){
        $model=new LoginForm();
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()&& $model->loaddate()){
                $user=Member::findOne(['username'=>$model->username]);
                $user->last_login_ip=$request->getUserIP();
                $user->last_login_time=time();
                $user->save(false);
                return ['success'=>'true','errorMsg'=>'','result'=>$user->toArray()];
            }
            return ['success'=>'false','errorMsg'=>$model->getErrors(),'result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }

    public function actionLoginOut(){
        \Yii::$app->user->logout();

        return ['success'=>'true','errorMsg'=>'','result'=>''];
    }

    public function actionUpdatePassword(){
        $model=new \frontend\models\UpdatePasswordForm();
        $member=Member::findOne(['id'=>\Yii::$app->user->id]);
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->username=$member->username;
            if($model->load($request->post())&& $model->validate()){


//                var_dump($model);exit;
                $member->password_hash=\Yii::$app->security->generatePasswordHash($model->newpassword);
                $member->save(false);

                return ['success'=>'true','errorMsg'=>'','result'=>$member->toArray()];
            }
            return ['success'=>'false','errorMsg'=>$model->getErrors(),'result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }


    public function actionUserInfo(){
        $request=\Yii::$app->request;
        if($request->isPost){
          $user=  Member::findOne(['id'=>\Yii::$app->user->id])->toArray();
            return ['success'=>'true','errorMsg'=>'','result'=>$user];
        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }

    public function actionAddAddress(){
        $request=\Yii::$app->request;
        $model=new Address();
        if($request->isPost){

            if($model->load($request->post()) && $model->validate()){

                $model->user_id=\Yii::$app->user->id;
                $model->save();
                $result=Address::find()->where(['user_id'=>$model->user_id])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$result];
            }

            return ['success'=>'false','errorMsg'=>$model->getErrors(),'result'=>''];

        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }
    public function actionAddressDelete(){

        $request=\Yii::$app->request;
        if($request->isGet){
           $id=$request->get();
            if($id!=null){
                Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete();
                $result=Address::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$result];
            }
            return ['success'=>'false','errorMsg'=>'地址ID不存在','result'=>''];

        }
        return ['success'=>'false','errorMsg'=>'请使用get方式请求','result'=>''];
    }

    public function actionAddressUpdate(){
        $request=\Yii::$app->request;
        if($request->isGet){
            $id=$request->get('id');
            $result=Address::findOne(['id'=>$id])->attributes;
            if($result==null){
                return ['success'=>'false','errorMsg'=>'地址ID不存在','result'=>''];
            }
            return ['success'=>'true','errorMsg'=>'','result'=>$result];
        }

        if($request->isPost){
            $model=new Address();
            if($model->load($request->post('id'))){
                $address=Address::findOne(['id'=>$model->id]);
                $address->load($request->post());
                $address->update();
                return ['success'=>'true','errorMsg'=>'','result'=>''];
            }
            return ['success'=>'false','errorMsg'=>'地址ID不存在','result'=>''];
        }
    }

    public function actionAddressList(){
        $request=\Yii::$app->request;
        if($request->isPost) {
            $result = Address::find()->where(['user_id' => \Yii::$app->user->id])->asArray()->all();
            if ($result != null) {
                return ['success' => 'true', 'errorMsg' => '', 'result' => $result];
            }
            return ['success' => 'false', 'errorMsg' => '该用户没有地址', 'result' => ''];
        }
        return ['success'=>'false','errorMsg'=>'请使用POst方式请求','result'=>''];
    }


    public function actionGoodsCategory(){
        $request=\Yii::$app->request;

        if($request->isPost){
            $lft=$request->post('lft');
            $rgt=$request->post('rgt');
            if($lft!=null && $rgt!=null){
                $result=GoodsCategory::find()->andWhere(['>=','lft',$lft])->andWhere(['<=','rgt',$rgt])->asArray()->all();
                if($result!=null){
                    return ['success'=>'true','errorMsg'=>'','result'=>$result];
                }
                return ['success'=>'false','errorMsg'=>'该分类不存在子类','result'=>''];
            }
            return ['success'=>'false','errorMsg'=>'该parent_id 不存在','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    public function actionGetChild(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $tree=$request->post('tree');
            if($tree!=null){
                $result=GoodsCategory::find()->where(['tree'=>$tree])->orderBy(['lft'=>'asc'])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$result];
            }
            return ['success'=>'false','errorMsg'=>'该tree不存在','result'=>''];

        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }

    public  function actionFindParent(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $parent_id=$request->post('parent_id');

            if($parent_id!=null){
                $result=GoodsCategory::findOne(['id'=>$parent_id]);
                if($result!=null){
                    $result=$result->attributes;
                }
                return ['success'=>'true','errorMsg'=>'','result'=>$result];
            }
            return ['success'=>'false','errorMsg'=>'该parent_id不存在','result'=>''];

        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    public function actionGetGoodsByCategory(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $category=$request->post('category');
            if($category!=null){
                $goods=Goods::find()->where(['goods_category_id'=>$category])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$goods];
            }
            return ['success'=>'false','errorMsg'=>'该category_id不存在','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }

    public function actionGetGoodsByBrand(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $brand_id=$request->post('brand_id');

            if($brand_id!=null){
                $goods=Goods::find()->where(['brand_id'=>$brand_id])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$goods];
            }
            return ['success'=>'false','errorMsg'=>'该brand_id不存在','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    public function actionGetArticleCategory(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $result=ArticleCategory::find()->asArray()->all();
            return ['success'=>'true','errorMsg'=>'','result'=>$result];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    public function actionGetArticleByArticleCategory(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $articlecategoryid=$request->post('articlecategoryid');
            if($articlecategoryid!=null){
                $result=Article::find()->where(['article_category_id'=>$articlecategoryid])->asArray()->all();
                return ['success'=>'true','errorMsg'=>'','result'=>$result];
            }
            return ['success'=>'false','errorMsg'=>'该article_category_id不存在','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }

    public function actionGetArticleCategoryByArticle(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $article_id=$request->post('article_id');
            if($article_id!=null){
               $article=Article::findOne(['id'=>$article_id]);
               if($article!=null){
                   $category_id=$article->article_category_id;
                   $category=ArticleCategory::findOne(['id'=>$category_id]);
                   if($category!=null){
                       $category=$category->attributes;
                       return ['success'=>'true','errorMsg'=>'','result'=>$category];
                   }
                   return ['success'=>'false','errorMsg'=>'该文章分类不存在','result'=>''];
               }
                return ['success'=>'false','errorMsg'=>'该文章不存在','result'=>''];
            }
            return ['success'=>'false','errorMsg'=>'该article_id为空','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    public function actionCartAdd(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $good_id=$request->post('good_id');
            $amount=$request->post('amount');
            $user=\Yii::$app->user->isGuest;
               if($user){
                   $goods=Goods::findOne(['id'=>$good_id]);
                   if($goods==null){
                       return ['success'=>'false','errorMsg'=>'商品ID不存在','result'=>''];
                   }
                   $cookies=\Yii::$app->request->cookies;
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
                   $result=serialize($cart);
                   $cookies=\Yii::$app->response->cookies;
                   $cookie=new Cookie([
                      'name'=>'cart',
                       'value'=>$result
                   ]);
                   $cookies->add($cookie);

               }else{
                   $cookies=\Yii::$app->request->cookies;
                   $cookie=$cookies->get('cart');
                   if($cookie==null){
                       $cart=Cart::findOne(['user_id'=>\Yii::$app->user->id,'good_id'=>$good_id]);
                       if($cart==null){
                           $model=new Cart();
                           $model->user_id=\Yii::$app->user->id;
                           $model->good_id=$good_id;
                           $model->amount=$amount;
                           $model->save();
                       }else{
                          $cart->amount+=$amount;
                          $cart->save();
                       }
                   }else{
                     $result=unserialize($cookie->value);
                       foreach ($result as $key=>$row){
                           $cart=Cart::findOne(['user_id'=>\Yii::$app->user->id,'good_id'=>$key]);
                           if($cart==null){
                               $model=new Cart();
                               $model->user_id=\Yii::$app->user->id;
                               $model->good_id=$key;
                               $model->amount=$row;
                               $model->save();
                           }else{
                               $cart->amount+=$row;
                               $cart->save();
                           }
                       }
                     $cookies=\Yii::$app->response->cookies;
                       $cookies->remove('cart');
                   }

               }
            return ['success'=>'true','errorMsg'=>'','result'=>''];
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];

    }



    public function actionUpdateAmount(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $good_id=$request->post('good_id');
            $amount=$request->post('amount');
            $user=\Yii::$app->user->isGuest;
            if($user){
                 $cookies=\Yii::$app->request->cookies;
                 $cookie=$cookies->get('cart');
                 if($cookie!=null){
                     $cart=unserialize($cookie->value);
                     if(key_exists($good_id,$cart)){
                         $cart[$good_id]=$amount;
                     }

                     $cookie=new Cookie([
                         'name'=>'cart',
                         'value'=>serialize($cart)
                     ]);
                     $cookies=\Yii::$app->response->cookies;
                     $cookies->add($cookie);

                 }else{
                     return ['success'=>'false','errorMsg'=>'购物车没有数据','result'=>''];
                 }
            }else{

                $cart=Cart::findOne(['user_id'=>\Yii::$app->user->id,'good_id'=>$good_id]);
                $cart->amount=$amount;
                $cart->save();
            }
            $goods=Goods::findOne(['id'=>$good_id])->attributes;

            return ['success'=>'true','errorMsg'=>'','result'=>$goods];
        }

        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }



    public function actionDeleteCart(){
        $request=\Yii::$app->request;
        if($request->isPost){
            $good_id=$request->post('good_id');
            $amount=$request->post('amount');
            if(\Yii::$app->user->isGuest){
               if($amount==0){
                   $cookies=\Yii::$app->request->cookies;
                   $cookie=$cookies->get('cart');
                   $result=unserialize($cookie->value);
                   $cart=[];
                  foreach ($result as $key=>$row){
                      if($key==$good_id){
                          unset($row,$key);
                      }else{
                          $cart[$key]=$row;
                      }
                  }
               return ['success'=>'true','errorMsg'=>'','result'=>$cart];
               }
            }else{
                if($amount==0){
                    $goods=Cart::findOne(['user_id'=>\Yii::$app->user->id,'good_id'=>$good_id]);
                    if($goods!=null){
                        $goods->delete();
                        $result=Cart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
                        return ['success'=>'true','errorMsg'=>'','result'=>$result];
                    }else{
                        return ['success'=>'false','errorMsg'=>'good_id不存在','result'=>''];
                    }
                }
            }
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }

    public  function actionCartDeleteAll(){
        $request=\Yii::$app->request;
        if($request->isPost){
            if(\Yii::$app->user->isGuest){
                $cookies=\Yii::$app->response->cookies;
                $cookies->remove('cart');
                return ['success'=>'true','errorMsg'=>'','result'=>''];
            }else{
                $result=Cart::findAll(['user_id'=>\Yii::$app->user->id]);
                foreach ($result as $row){
                    $row->delete();
                }
                return ['success'=>'true','errorMsg'=>'','result'=>''];
            }
        }
        return ['success'=>'false','errorMsg'=>'请使用post方式请求','result'=>''];
    }


    //验证码接口
    public function actions(){
            return [
                'captcha'=>[
                    'class'=>'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                    'minLength'=>4,//验证码最小长度
                    'maxLength'=>4,//最大长度
                ]
            ];
        }

    //http://www.yii2shop.com/api/captcha.html 显示验证码
    //http://www.yii2shop.com/api/captcha.html?refresh=1 获取新验证码图片地址
    //http://www.yii2shop.com/api/captcha.html?v=59573cbe28c58 新验证码图片地址





        public function actionUpload(){
        $file=New UploadedFile();
        $img=$file->getInstanceByName('img');
        if($img){
            $img_path='/upload/img/'.uniqid().'.'.$img->extension;
            $result=$img->saveAs(\Yii::getAlias('@webroot').$img_path,false);
            if($result){
                return ['success'=>'true','errorMsg'=>'','result'=>$img_path];
                }else{
                return ['success'=>'false','errorMsg'=>$img->error,'result'=>''];
              }
            }
            return ['success'=>'false','errorMsg'=>'没有图偏上传','result'=>''];
        }

        public function actionPage(){
            $page_size=\Yii::$app->request->get('page_size',1);
            $page_size=$page_size<1?1:$page_size;
            $page_size_count=\Yii::$app->request->get('page_size_count',2);
            $query=Goods::find();
            $goods_count=$query->count();
            $goods=$query->offset(($page_size-1)*$page_size_count)->limit($page_size_count)->asArray()->all();

            return ['success'=>'true','errorMsg'=>'','result'=>[
                'goods'=>$goods,
                'goods_count'=>$goods_count,
                'page_size'=>$page_size,
                'page_size_count'=>$page_size_count,
            ]];
        }


    public function actionSms(){
        // 配置信息
        if($_POST['name']==null){
            $name='';
        }else{
            $name=$_POST['name'];
        }
        $tel=$_POST['tel'];

        var_dump($name,$tel);
        if(!preg_match('/1[34579]{1}\d{9}/',$tel)){
            return ['success'=>'false','errorMsg'=>'你输入的手机号码有误','result'=>'']; exit;
        }

        $config = [
            'app_key'=> '24480026',
            'app_secret' => '49eabaa8716d172a94deb3a0c20bd9a9',
//            // 'sandbox'    => true,  // 是否为沙箱环境，默认false
        ];
//        // 使用方法一
        $client= new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend();
        $code= rand(100000, 999999);
        $req->setRecNum("$tel")
            ->setSmsParam([
                'name'=>$name,
                'code' =>$code])
            ->setSmsFreeSignName('周浩')
            ->setSmsTemplateCode('SMS_71745035');
        $resp = $client->execute($req);
//             $resp=1;
        if($resp){

            \Yii::$app->cache->set($tel,$code,6*60);
            return ['success'=>'true','errorMsg'=>'','result'=>$code];
        }else {
//            return '发送失败';
            return ['success'=>'false','errorMsg'=>'发送失败','result'=>''];
        }

    }

}