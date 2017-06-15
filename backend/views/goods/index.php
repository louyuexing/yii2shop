
<?php
echo '<div class="container">
    <div class="input-group col-lg-4">';
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'select')->textInput(['class'=>"form-control input-xs"])->label('');
echo' </div>
</div>';
echo \yii\bootstrap\Html::submitButton('搜索',['class'=>" btn btn-primary"]);
\yii\bootstrap\ActiveForm::end();
?>
<style>
    .btn-sm{

        position: absolute;
        top:70px;
        right:160px;
    }
    .btn-primary{
        position: absolute;
        top:70px;
        left:500px;
    }
</style>
<table class="table table-bordered">
    <?=\yii\bootstrap\Html::a('增加',['goods/add'],['class'=>'btn btn-info btn-sm'])?>

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
            <?=\yii\bootstrap\Html::a('删除',['goods/delete','id'=>$row->id],['class'=>'btn btn-danger btn-xs'])?>
            <?=\yii\bootstrap\Html::a('修改',['goods/update','id'=>$row->id],['class'=>'btn btn-warning btn-xs'])?>
            <?=\yii\bootstrap\Html::a('查看',['goods/info','id'=>$row->id],['class'=>'btn btn-warning btn-xs'])?>
            <?=\yii\bootstrap\Html::a('相册',['goods/img','id'=>$row->id],['class'=>'btn btn-info btn-xs'])?>
        </td>
    <tr>
    <?php endforeach;?>

</table>
<?=\yii\widgets\LinkPager::widget([
        'pagination'=>$page,
])?>
