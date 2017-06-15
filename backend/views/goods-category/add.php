<?php
/**
 * @var $this \yii\web\View
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'parent_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';
echo $form->field($model,'intro');
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
//<link rel="stylesheet" href="/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
//    <script type="text/javascript" src="/zTree/js/jquery-1.4.4.min.js"></script>
//    <script type="text/javascript" src="/zTree/js/jquery.ztree.core.js"></script>

$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes=\yii\helpers\Json::encode($result);
$js=new \yii\web\JsExpression(
    <<<JS
         var zTreeObj;
    // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）

    var setting = {
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "parent_id",
                rootPId: 0
            }
        },
        callback:{
            onClick:function(event,treeId,treeNOde){
             // console.log(treeNOde.id);  
             $('#goodscategory-parent_id').val(treeNOde.id);
            }
        }
    };
    // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
    var zNodes = {$zNodes};
  
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        var node=zTreeObj.getNodeByParam("id",$('#goodscategory-parent_id').val(),null )
        zTreeObj.selectNode(node);
JS

);
$this->registerJs($js);
?>
