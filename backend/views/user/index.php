<table class="table table-bordered">
    <?=\yii\bootstrap\Html::a('注册',['user/add'],['class'=>'btn btn-primary '])?>
    <tr>
        <td>id</td>
        <td>用户名</td>
        <td>密码</td>
        <td>状态</td>
        <td>最后登录时间</td>
        <td>最后登录IP</td>
        <td>身份</td>
        <td>操作</td>
    <tr>
        <?php foreach($result as $row):?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['username']?></td>
        <td><?=$row['password_hash']?></td>
        <td><?=$row->status>0?'正常':'隐藏'?></td>
        <td><?=$row['last_login_time']?></td>
        <td><?=$row['last_login_ip']?></td>
        <td>
            <?php $roles=Yii::$app->authManager->getRolesByUser($row['id']);
            foreach ($roles as $role){
                echo $role->description  ;
                echo '/';
            }


            ?>
        </td>
        <td>
            <?=\yii\bootstrap\Html::a('删除',['user/delete','id'=>$row->id],['class'=>'btn btn-danger btn-xs'])?>
            <?=\yii\bootstrap\Html::a('修改',['user/update','id'=>$row->id],['class'=>'btn btn-warning btn-xs'])?>
        </td>
    <tr>
        <?php endforeach;?>

</table>
<?=\yii\bootstrap\Html::a('注销',['user/login-out'],['class'=>'btn btn-warning btn-xs'])?>