<table class="table table-bordered">
    <tr>
        <td>名称</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>
                <?=\yii\bootstrap\Html::a('删除',['rbac/del','name'=>$model->name],['class'=>'btn btn-danger btn-xs'])?>
                <?=\yii\bootstrap\Html::a('修改',['rbac/edit','name'=>$model->name],['class'=>'btn btn-warning btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
</table>