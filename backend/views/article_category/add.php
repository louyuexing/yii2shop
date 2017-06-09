<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort');
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\ArticleCategory::$status);
echo $form->field($model,'is_help',['inline'=>true])->radioList(\backend\models\ArticleCategory::$is_help);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
//'id' => 'ID',
//            'name' => '名称',
//            'intro' => '简介',
//            'sort' => '排序',
//            'status' => '状态',
//            'is_help' => '类型',