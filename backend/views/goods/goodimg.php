<?php
echo '<div class="ii">';
foreach ($result as $row){
    echo '<div id="i">';
    if(Yii::$app->user->can('goods/img-delete')){
        echo \yii\bootstrap\Html::a('删除',['goods/img-delete','id'=>$row->id,'gid'=>$id],['class'=>'btn btn-danger btn-xs']),\yii\bootstrap\Html::img($row->img,['height'=>150,'width'=>150]);
    }

    echo '</div>';
}
echo '</div>';


?>
<?php
echo '<div class="iii">';
if(Yii::$app->user->can('goods/img-delete-all')){
    echo \yii\bootstrap\Html::a('删除所有',['goods/img-delete-all','id'=>$id],['class'=>'btn btn-danger']);
}
if(Yii::$app->user->can('goods/add-img')){
    echo \yii\bootstrap\Html::a('添加',['goods/add-img','id'=>$id],['class'=>'btn btn-info']);
}


  echo  \yii\bootstrap\Html::a('返回首页',['goods/index','id'=>$row->id],['class'=>'btn btn-primary']).'</div>';
?>


<style>
   img{

   }
    #i{
        position: relative;
       height: 150px;
        width: 150px;
        float: left;
        margin-right: 20px;
        margin-top: 40px;
    }
   .ii{
       height: 0px;
       width: 950px;
   }
    #i a{
        position: absolute;
        float: right;
        top:128px;
        left: 114px;
    }
    .iii{
        position: absolute;
        height: 0px;
        width: 1200px;
    }
    .iii a{

        position: relative;
        float: left;
    }

</style>
