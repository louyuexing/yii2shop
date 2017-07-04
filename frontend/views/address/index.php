<!-- 右侧内容区域 start -->
<div class="content fl ml10">
    <div class="address_hd">
        <h3>收货地址薄</h3>
        <?php foreach ($result as $row):?>
            <dl>
                <dt>
                    <?php echo $row->id.'--',$row->name.'--',$model->address($row->provinces),'--',$model->address($row->city).'--',$model->address($row->area).'--',$row->addressinfo.'--',$row->phone?>
                </dt>
                <?=\yii\helpers\Html::a('修改',['address/update','id'=>$row->id])?>
                <?=\yii\helpers\Html::a('删除',['address/delete','id'=>$row->id])?>

                <?php if($row->status){
                    echo \yii\helpers\Html::a('取消默认地址',['address/default','id'=>$row->id]);
                }else{ echo \yii\helpers\Html::a('设置为默认地址',['address/default','id'=>$row->id]);}
                ?>
            </dl>
        <?php endforeach;?>

    </div>

    <div class="address_bd mt10">
        <h4>新增收货地址</h4>
        <?php   $form=\yii\widgets\ActiveForm::begin();?>
        <ul>
            <li>
                <?php
                echo $form->field($model,'name')->input('text',['class'=>'txt']);
                ?>
            </li>
            <!--                    'provinces' => '省份',-->
            <!--                    'city' => '市县',-->
            <!--                    'area' => '城镇',-->
            <li><label>请选择区域</label>
                <?php
                echo $form->field($model,'provinces',['template'=>"{input}",'options'=>['tag'=>false]])->dropDownList([''=>'--请选择市--']);
                echo $form->field($model,'city',['template'=>"{input}",'options'=>['tag'=>false]])->dropDownList([''=>'--请选择市--']);
                echo $form->field($model,'area',['template'=>"{input}",'options'=>['tag'=>false]])->dropDownList([''=>'--请选择市--'])


                ?>
            </li>
            <li>
                <?php
                echo $form->field($model,'addressinfo')->input('text',['class'=>'txt']);
                ?>
            </li>
            <li>

                <?php
                echo $form->field($model,'phone')->input('text',['class'=>'txt']);
                ?>
            </li>
            <li>

                <?php
                echo $form->field($model,'status')->checkbox();
                ?>
            </li>
            <li>
                <label for="">&nbsp;</label>
                <input type="submit" name="" class="btn" value="保存" />
            </li>
        </ul>
        <?php   \yii\widgets\ActiveForm::end();?>
    </div>

</div>
<!-- 右侧内容区域 end -->

<?php
/**
 * @var $this \yii\web\view
 */
$url=\yii\helpers\Url::to(['address/find-address']);
$this->registerJs(new \yii\web\JsExpression(
        <<<js
$(function(){
    var parent_id;
    var date={
        parent_id:0,
    }
    $.getJSON('$url',date,function(result){
       
         var html='<option>--请选择省份--</option>';
      $(result).each(function(i,v){
          html+='<option value='+v.id+'>'+v.name+'</option>';
      });
      $("#address-provinces").html(html);
    })
    
    
    
});


$("#address-provinces").change(function(){
     $("#address-city").find('option:not(:first)').remove();
     $("#address-area").find('option:not(:first)').remove();
  
   var parent_id=$(this).find('option:not(:first):checked').val();
   var date={
       'parent_id':parent_id,
   }
    var html='<option>--请选择市区--</option>';
   $.getJSON('$url',date,function(result){
       $(result).each(function(i,v){
            html+='<option value='+v.id+'>'+v.name+'</option>';
       });
       $("#address-city").html(html);
   });
   
})
      
$("#address-city").change(function(){
    $("#address-area").find('option:not(:first)').remove();
   var parent_id=$(this).find('option:not(:first):checked').val();
   var date={
       'parent_id':parent_id,
   }
    var html='<option>--请选择区县--</option>';
   $.getJSON('$url',date,function(result){
       $(result).each(function(i,v){
            html+='<option value='+v.id+'>'+v.name+'</option>';
       });
       $("#address-area").html(html);
   });
   
   $(".btn").click(function(){
       
       
       
   });
   
   
})
js


));

?>
