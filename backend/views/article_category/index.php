<table border="1px" class="table">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>商品简介</td>
        <td>排序</td>
        <td>状态</td>
        <td>ishelp</td>
        <td>操作</td>
    </tr>
    <?php foreach($cates as $articlecategoryinfo):?>
        <tr>
            <td><?=$articlecategoryinfo->id?></td>
            <td><?=$articlecategoryinfo->name?></td>
            <td><?=$articlecategoryinfo->intro?></td>
            <td><?=$articlecategoryinfo->sort?></td>
            <td><?=\backend\models\ArticleCategory::$status[$articlecategoryinfo->status]?></td>
            <td><?=\backend\models\ArticleCategory::$is_help[$articlecategoryinfo->is_help]?></td>
            <td>
                <?php if(Yii::$app->user->can('article_category/delete')){
                    echo \yii\bootstrap\Html::a('删除',['article_category/delete','id'=>$articlecategoryinfo->id],['class'=>'btn btn-danger btn-xs']);

                }?>

                <?php if(Yii::$app->user->can('article_category/update')){
                  echo   \yii\bootstrap\Html::a('修改',['article_category/update','id'=>$articlecategoryinfo->id],['class'=>'btn btn-warning btn-xs']);
                }?>
            </td>
        </tr>
    <?php endforeach;?>
     <?php if(Yii::$app->user->can('article_category/add')){
         echo \yii\bootstrap\Html::a('添加',['article_category/add'],['class'=>'btn btn-info ']);
     }?>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
     'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'
]);