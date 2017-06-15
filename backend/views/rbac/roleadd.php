<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermission());
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-primary']);
\yii\bootstrap\ActiveForm::end();