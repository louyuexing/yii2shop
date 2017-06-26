<?php

namespace backend\controllers;


use backend\components\RbacFilter;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsImg;
use backend\models\GoodsIntro;
use backend\models\GoodsSearchForm;
use xj\uploadify\UploadAction;
use backend\models\Brand;
use backend\models\Goods;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'only'=>['add','delete','update','img','img-delete','info'],
            ]
        ];
    }


    public function actionIndex()
    {
        $model = new GoodsSearchForm();
        $query = Goods::find();

        /*if($keyword = \Yii::$app->request->get('keyword')){
            $query->andWhere(['like','name',$keyword]);
        }
        if($sn = \Yii::$app->request->get('sn')){
            $query->andWhere(['like','sn',$sn]);
        }*/
        //接收表单提交的查询参数
        $model->search($query);
        //商品名称含有"耳机"的  name like "%耳机%"
        //$query = Goods::find()->where(['like','name','耳机']);
        $page = new Pagination([
            'totalCount'=>$query->count(),
            'pageSize'=>5
        ]);

//        $models = $query->limit($pager->limit)->offset($pager->offset)->all();
//        return $this->render('index',['models'=>$models,'pager'=>$pager,'model'=>$model]);
//        $result=Goods::find()->all();
//        $query=Goods::find();
//        $model=new Goods();
//        $request=new Request();
//        if($request->isPost){
//            if($model->validate()){
//                $search=$request->post('Goods')['select'];
//                $query=Goods::find()->where(['like','name',$search]);
//                $count=$query->count();
//                $page= new Pagination(['totalCount'=>$count,'defaultPageSize'=>1]);
//                $cates=$query->offset($page->offset)->limit($page->limit)->all();
//                return $this->render('index',['page'=>$page,'cates'=>$cates,'model'=>$model]);
//            }

//        }
//            $count = $query->count();
//            $page = new Pagination(['totalCount' => $count, 'defaultPageSize' => 2]);
            $cates = $query->offset($page->offset)->limit($page->limit)->all();
            return $this->render('index', ['page' => $page, 'cates' => $cates, 'model' => $model]);

    }

//    public function actionSearch(){
//        $model=new Goods();
//        $request=new Request();
//        if($request->isPost){
//            if($model->validate()){
//                $search=$request->post('Goods')['select'];
//                $query=Goods::find()->where(['like','name',$search]);
//                $count=$query->count();
//                $page= new Pagination(['totalCount'=>$count,'defaultPageSize'=>1]);
//                $cates=$query->offset($page->offset)->limit($page->limit)->all();
//                return $this->render('index',['page'=>$page,'cates'=>$cates,'model'=>$model]);
//            }
//
//        }
//    }


     public  function actionAdd(){
        $model=new Goods();
        $goodsintro=new GoodsIntro();
        $request=new Request();
         $create=new GoodsDayCount;
        if($request->isPost){
            $model->load($request->post());
            $model->create_time=time();
            $day=date('Ymd',time());
            $dayModel=GoodsDayCount::findOne(['day'=>$day]);
            if($dayModel){
                $dayModel->count=$dayModel->count+1;
                $dayModel->save();
            }else{
                $create->count=1;
                $create->day=$day;
                $create->save();
            }
            $dayModel=GoodsDayCount::findOne(['day'=>$day]);
            if($model->validate()){
                $model->sn=$day.str_repeat('0',5-strlen($dayModel->count)).$dayModel->count;
                $model->save();
                $goodsintro->goods_id=$model->id;
                $goodsintro->content= $request->post('w1');
                $goodsintro->save();
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['goods/index']);
            }

        }
        $result=Brand::find()->all();
        $goods_category=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result,'goods_category'=>$goods_category,'goodsintro'=>$goodsintro]);
     }



      public function actionDelete($id){
         Goods::findOne(['id'=>$id])->delete();
          \Yii::$app->session->setFlash('success','删除成功');
          return $this->redirect(['goods/index']);
      }

    public  function actionUpdate($id){
        $model=Goods::findOne(['id'=>$id]);

        $goodsintro=GoodsIntro::findOne(['goods_id'=>$id]);
        $goodsback=GoodsIntro::findOne(['goods_id'=>$id]);
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            $model->create_time=time();
            $day=date('Ymd',time());
            $dayModel=GoodsDayCount::findOne(['day'=>$day]);
            if($model->validate()){
                $model->save();
                $goodsintro->goods_id=$model->id;
                $goodsintro->content=$request->post('w1');
//                var_dump($goodsintro->content);exit;
                $goodsintro->save();
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['goods/index']);
            }

        }
        $result=Brand::find()->all();
        $goods_category=ArrayHelper::merge([['id'=>0,'name'=>'顶级分类','parent_id'=>0]],GoodsCategory::find()->asArray()->all());
        return $this->render('add',['model'=>$model,'result'=>$result,'goods_category'=>$goods_category,'goodsback'=>$goodsback]);
    }


    public function actionInfo($id){
        $goodsintro=GoodsIntro::findOne(['goods_id'=>$id]);
        return $this->render('info',['goodsintro'=>$goodsintro]);
    }


    public function actionAddImg($id){
        $model=new GoodsImg();
        $request=new Request();
        $db = \Yii::$app->db;
        if($request->isPost){
            $file =UploadedFile::getInstances($model, 'file');
//            $path='upload/'.date("YmdH",time()).'/';
            foreach ($file as $key=> $fl) {
                $gid=$id;
                $filename='/upload/goodsimg/' .$key.time() .$fl->baseName. '.' . $fl->extension;
                $fl->saveAs(\Yii::getAlias('@webroot').'/upload/goodsimg/' .$key.time() .$fl->baseName. '.' . $fl->extension);
//                $model->goods_id=$gid;
//                $model->img=$filename;
//                $model->insert();
                $db->createCommand()->insert('goods_img',['goods_id'=>$gid,'img'=>$filename])->execute();


            }
            return $this->redirect(['goods/img','id'=>$id]);

        }

        return $this->render('addimg',['model'=>$model]);
    }

    public function actionImg($id){
        $result=GoodsImg::find()->where(['goods_id'=>$id])->all();

        if(count($result)==0){
            \Yii::$app->session->setFlash('danger','没有图片请上传');
            return $this->redirect(['goods/add-img','id'=>$id]);
        }else{

            return $this->render('goodimg',['result'=>$result,'id'=>$id]);

        }

    }
    public function actionImgDelete($id,$gid){
        GoodsImg::findOne(['id'=>$id])->delete();
        return $this->redirect(['goods/img','id'=>$gid]);
    }











    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
//                'format' => function (UploadAction $action) {
//                    $fileext = $action->uploadfile->getExtension();
//                    $filehash = sha1(uniqid() . time());
//                    $p1 = substr($filehash, 0, 2);
//                    $p2 = substr($filehash, 2, 2);
//                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
//                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();
                    $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],

            'upload' => [
                    'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
//                    "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                 ]
             ]
          ];
    }


}
