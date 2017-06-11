<table border="1px" class="table">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>商品LOgo</td>
        <td>商品简介</td>
        <td>排序</td>
        <td>状态</td>
        <td>操作</td>
    </tr>
    <?php foreach($result as $brandinfo):?>
        <tr>
            <td><?=$brandinfo->id?></td>
            <td><?=$brandinfo->name?></td>
            <td><?=\yii\bootstrap\Html::img($brandinfo->logo,['height'=>40])?></td>

            <td><?=$brandinfo->intro?></td>
            <td><?=$brandinfo->sort?></td>
            <td><?=\backend\models\Brand::$status[$brandinfo->status]?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['brand/delete','id'=>$brandinfo->id],['class'=>'btn btn-danger btn-xs'])?>
                <?=\yii\bootstrap\Html::a('修改',['brand/update','id'=>$brandinfo->id],['class'=>'btn btn-warning btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\bootstrap\Html::a('添加',['brand/add'],['class'=>'btn btn-info '])?>