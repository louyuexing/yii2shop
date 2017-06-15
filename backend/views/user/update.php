<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo  $form->field($user,'username');
echo $form->field($user,'oldpassword')->passwordInput();
echo $form->field($user,'newpassword')->passwordInput();
echo $form->field($user,'repassword')->passwordInput();
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'异常']);
echo $form->field($model,'email');
echo \yii\bootstrap\Html::submitButton('注册',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();