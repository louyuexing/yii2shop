<table class="table" border="1px">
    <tr>
        <td>id</td>
        <td>tree</td>
        <td>lft</td>
        <td>rgt</td>
        <td>深度</td>
        <td>名称</td>
        <td>上级分类</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($result as $row):?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['tree']?></td>
            <td><?=$row['lft']?></td>
            <td><?=$row['rgt']?></td>
            <td><?=$row['depth']?></td>
            <td><?=str_repeat('---',$row['depth']).$row['name']?></td>
            <td><?=$row['parent_id']?$row->parent->name:''?></td>
            <td><?=$row['intro']?></td>
            <td><?=\yii\bootstrap\Html::a('删除',['goods-category/delete','id'=>$row['id']],['class'=>'btn btn-danger btn-xs'])?>
                <?=\yii\bootstrap\Html::a('修改',['goods-category/update','id'=>$row['id']],['class'=>'btn btn-warning btn-xs'])?>
            </td>
    <tr>
    <?php endforeach;?>
    <?=\yii\bootstrap\Html::a('添加',['goods-category/add'],['class'=>'btn btn-info btn-xs'])?>
</table>