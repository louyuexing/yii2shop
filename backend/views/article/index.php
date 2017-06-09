<table border="1px" class="table">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>商品简介</td>
        <td>排序</td>
        <td>状态</td>
        <td>创建时间</td>
        <td>操作</td>
    </tr>
    <?php foreach($result as $articleinfo):?>
        <tr>
            <td><?=$articleinfo->id?></td>
            <td><?=$articleinfo->name?></td>
            <td><?=$articleinfo->intro?></td>
            <td><?=$articleinfo->sort?></td>
            <td><?=$articleinfo->status?></td>
            <td><?=$articleinfo->create_time?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['article/delete','id'=>$articleinfo->id],['class'=>'btn btn-danger btn-xs'])?>
                <?=\yii\bootstrap\Html::a('修改',['article/update','id'=>$articleinfo->id],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('查看',['article/findone','id'=>$articleinfo->id],['class'=>'btn btn-warning btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['article/add'],['class'=>'btn btn-info '])?>

</table>