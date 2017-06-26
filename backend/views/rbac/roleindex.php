<table class="table table-bordered">
    <tr>
        <td>名称</td>
        <td>简介</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>
                <?php
                foreach (Yii::$app->authManager->getPermissionsByRole($model->name) as $permission){
                    echo $permission->description;
                    echo '/';
                }
                ?>
            </td>
            <td>
                <?php if(Yii::$app->user->can('rbac/role-del')){
                    echo \yii\bootstrap\Html::a('删除',['rbac/role-del','name'=>$model->name],['class'=>'btn btn-danger btn-xs']);
                }?>
                <?php if(Yii::$app->user->can('rbac/role-edit')){
                    echo \yii\bootstrap\Html::a('修改',['rbac/role-edit','name'=>$model->name],['class'=>'btn btn-warning btn-xs']);
                }?>

            </td>
        </tr>
    <?php endforeach;?>
</table>