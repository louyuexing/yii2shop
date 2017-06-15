<?php
/**
 * @var $this \yii\web\View
 * */
use \kucha\ueditor\UEditor;

use yii\web\JsExpression;
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
//echo $form->field($model,'sn');
echo $form->field($model,'logo')->hiddenInput();

echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \xj\uploadify\Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        $("#imglogo").attr("src",data.fileUrl).show();
        $("#goods-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);

if($model->logo){
    echo \yii\bootstrap\Html::img($model->logo,['id'=>'imglogo','height'=>50]);
}else{
    echo \yii\bootstrap\Html::img('',['style'=>'display:none','id'=>'imglogo','height'=>50]);
}
echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<ul id="treeDemo" class="ztree"></ul>';

echo $form->field($model,'brand_id')->dropDownList(\yii\helpers\ArrayHelper::map($result,'id','name'),['prompt'=>'请选择']);
echo $form->field($model,'market_price');
echo $form->field($model,'shop_price');
echo $form->field($model,'stock');
echo $form->field($model,'is_on_sale',['inline'=>true])->radioList([1=>'在售',0=>'下架']);
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'回收']);
echo $form->field($model,'sort');
//echo $form->field($model,'create_time');

echo \kucha\ueditor\UEditor::widget(['name'=>'content']);

echo \yii\bootstrap\Html::submitInput('添加',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

//$zNode=\yii\helpers\Json::encode($result);
//$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//$this->registerJsFile('@web/zTree/js/jquery-1.4.4.min.js',['depends'=>\yii\web\JqueryAsset::className()]);
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
$zNodes=\yii\helpers\Json::encode($goods_category);

$js =new JsExpression(
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
             $("#goods-goods_category_id").val(treeNOde.id);
          
            }
          }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$zNodes};
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);
        var node=zTreeObj.getNodeByParam("id",$('#goods-goods_category_id').val(),null )
        zTreeObj.selectNode(node);

JS

);
$this->registerJs($js);