<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo  $form->field($model,'username');
echo $form->field($model,'status',['inline'=>true])->radioList([1=>'正常',0=>'异常']);
echo $form->field($model,'role')->checkboxList(\backend\models\User::loadrole());
echo $form->field($model,'email');
echo \yii\bootstrap\Html::submitButton('修改',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();