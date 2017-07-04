<?php
use yii\helpers\Html;
?>
<!-- 登录主体部分start -->
<div class="login w990 bc mt10 regist">
    <div class="login_hd">
        <h2>用户注册</h2>
        <b></b>
    </div>
    <div class="login_bd">
        <div class="login_form fl">
            <?php
            $form=\yii\widgets\ActiveForm::begin([
                'fieldConfig'=>[
                    'options'=>[
                        'tag'=>'li',
                    ],
                    'errorOptions'=>[
                        'tag'=>'p'
                    ]
                ]
            ]);
             echo '<ul>';
            echo $form->field($model,'username')->textInput(['class'=>'txt']);
            echo $form->field($model,'password')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'repassword')->passwordInput(['class'=>'txt']);
            echo $form->field($model,'email')->textInput(['class'=>'txt']);
            echo $form->field($model,'tel')->textInput(['class'=>'txt']);
            $button=Html::button('点击发送',['id'=>'send_sms_code']);
            echo $form->field($model,'smscode',['options'=>['class'=>'checkcode'],'template'=>"{label}\n{input}$button\n{hint}\n{error}"])->textInput(['class'=>'txt']);

            echo $form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(\yii\captcha\Captcha::className(),['template'=>'{input}{image}']);
//            echo $form->field($model,'code',['options'=>['class'=>'checkcode']],['inline'=>'true'])->widget(\yii\captcha\Captcha::className(),['template'=>'{input}{image}','captchaAction'=>'user/captcha']);
            echo '<li>
                        <label for="">&nbsp;</label>
                        <input type="submit" value="" class="login_btn">
                    </li>';
            echo '</ul>';
            \yii\widgets\ActiveForm::end()

            ?>
        </div>

        <div class="mobile fl">
            <h3>手机快速注册</h3>
            <p>中国大陆手机用户，编辑短信 “<strong>XX</strong>”发送到：</p>
            <p><strong>1069099988</strong></p>
        </div>

    </div>
</div>
<!-- 登录主体部分end -->


<?php
/* @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['user/sms']);
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
    $("#send_sms_code").click(function(){
        //发送验证码按钮被点击时
        //手机号
        var name=$("#member-username").val();
        var tel = $("#member-tel").val();
        var date={ 
            'name':name,
            'tel':tel}
        //AJAX post提交tel参数到 user/send-sms
        $.post('$url',date,function(back){
            if(back== 'success'){
                console.log('短信发送成功');
                alert('短信发送成功');
            }else{
                console.log(back);
            }
        });
    });
JS
));
