<?php
$form = \yii\bootstrap\ActiveForm::begin([
    'method' => 'get',
    //get方式提交,需要显式指定action
    'action'=>\yii\helpers\Url::to(['goods/index']),
    'options'=>['class'=>'form-inline']
]);
echo $form->field($model,'name')->textInput(['placeholder'=>'商品名'])->label(false);
echo $form->field($model,'sn')->textInput(['placeholder'=>'货号'])->label(false);
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();
?>

<table class="table table-bordered">
    <?=\yii\bootstrap\Html::a('增加',['goods/add'],['class'=>'btn btn-info btn-sm'])?>
    <thead>
    <tr>
        <td>id</td>
        <td>货号</td>
        <td>名称</td>
        <td>商标logo</td>
        <td>商品分类</td>
        <td>品牌</td>
        <td>市场价格</td>
        <td>商场价格</td>
        <td>库存</td>
        <td>是否上架</td>
        <td>状态</td>
        <td>排序</td>
        <td>添加时间</td>
        <td>操作</td>
    <tr>
    </thead>
    <tbody>
    <?php foreach($cates as $row):?>
        <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['sn']?></td>
        <td><?=$row['name']?></td>
        <td><?=\yii\bootstrap\Html::img('@web'.$row['logo'],['height'=>30,'width'=>60])?></td>
        <td><?=$row->goods->name?></td>
        <td><?=$row->brand->name?></td>
        <td><?=$row['market_price']?></td>
        <td><?=$row['shop_price']?></td>
        <td> <?=$row['stock']?></td>
        <td><?=$row->is_on_sale>0?'上架':'下架'?></td>
        <td><?=$row->status>0?'正常':'隐藏'?></td>
        <td><?=$row['sort']?></td>
        <td><?=date('Ymd',$row['create_time'])?></td>
        <td>
            <?php if(Yii::$app->user->can('goods/delete')){
            echo \yii\bootstrap\Html::a('删除',['goods/delete','id'=>$row->id],['class'=>'btn btn-danger btn-xs']);
            }?>
            <?php if(Yii::$app->user->can('goods/update')){
                echo \yii\bootstrap\Html::a('更新',['goods/update','id'=>$row->id],['class'=>'btn btn-warning btn-xs']);
            }?>
            <?php if(Yii::$app->user->can('goods/info')){
                echo \yii\bootstrap\Html::a('查看',['goods/info','id'=>$row->id],['class'=>'btn btn-primary btn-xs']);
            }?>
            <?php if(Yii::$app->user->can('goods/img')){
                echo \yii\bootstrap\Html::a('相册',['goods/img','id'=>$row->id],['class'=>'btn btn-primary btn-xs']);
            }?>
        </td>
    </tr>
    <?php endforeach;?>
            </tbody>
</table>
<?=\yii\widgets\LinkPager::widget([
        'pagination'=>$page,
])?>

<?php
/**
// * @var $this \yii\web\View
// */
//$this->registerCssFile('@webroot/datetables/css/jquery.dataTables.min.css');
//$this->registerJsFile('@webroot/datetables/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
//$this->registerJs('$(".table").DataTable({
//
//});');

/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({

});');