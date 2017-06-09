<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
//'id' => 'ID',
//            'name' => '名称',
//            'intro' => '简介',
//            'sort' => '排序',
//            'status' => '状态',
//            'is_help' => '类型',