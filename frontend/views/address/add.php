<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>收货地址</title>
    <link rel="stylesheet" href="style/base.css" type="text/css">
    <link rel="stylesheet" href="style/global.css" type="text/css">
    <link rel="stylesheet" href="style/header.css" type="text/css">
    <link rel="stylesheet" href="style/home.css" type="text/css">
    <link rel="stylesheet" href="style/address.css" type="text/css">
    <link rel="stylesheet" href="style/bottomnav.css" type="text/css">
    <link rel="stylesheet" href="style/footer.css" type="text/css">

<!--    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>-->
<!--    <script type="text/javascript" src="js/header.js"></script>-->
<!--    <script type="text/javascript" src="js/home.js"></script>-->
</head>
<body>

    <!-- 右侧内容区域 start -->
    <div class="content fl ml10">
        <div class="address_hd">
            <h3>收货地址薄</h3>
            <?php foreach ($result as $row):?>
                <dl>
                    <dt><?php echo $row->id.'--',$row->name.'--',$row->provinces.'--',$row->city.'--',$row->area.'--',$row->addressinfo.'--',$row->phone?></dt>
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
                    <li>
                        <?php
                        echo $form->field($model,'provinces')->input('text',['class'=>'txt address']);
                        ?>
                    </li>
                    <li>
                        <?php
                        echo $form->field($model,'city')->input('text',['class'=>'txt address']);
                        ?>
                    </li>
                    <li>
                        <?php
                        echo $form->field($model,'addressinfo')->input('text',['class'=>'txt address']);
                        ?>
                    </li>
                    <li>
                        <?php
                        echo $form->field($model,'area')->input('text',['class'=>'txt address']);
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
</div>

</body>
</html>