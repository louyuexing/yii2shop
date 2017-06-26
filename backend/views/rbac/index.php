<table class="table table-bordered" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <thead>
    <tr>
        <td>名称</td>
        <td>简介</td>
        <td>操作</td>
    </tr>
    </thead>
</tbody>
    <?php foreach($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td>
                <?php if(Yii::$app->user->can('rbac/del')){
                    echo \yii\bootstrap\Html::a('删除',['rbac/del','name'=>$model->name],['class'=>'btn btn-danger btn-xs']);
                }?>
                <?php if(Yii::$app->user->can('rbac/edit')){
                    echo \yii\bootstrap\Html::a('修改',['rbac/edit','name'=>$model->name],['class'=>'btn btn-warning btn-xs']);
                }?>
            </td>
        </tr>
    <?php endforeach;?>
</tbody>
</table>

<?php
/**
 * @var $this \yii\web\View
 */
$this->registerCssFile('//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css');
$this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerJs('$(".table").DataTable({

});');