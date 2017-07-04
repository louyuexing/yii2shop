<table class="table table-bordered">
    <thead>
    <tr>
        <td>id</td>
        <td>用户id</td>
        <td>收货人</td>
        <td>省份</td>
        <td>市</td>
        <td>县</td>
        <td>详细地址</td>
        <td>电话号码</td>
        <td>配送方式id</td>
        <td>配送方式名称</td>
        <td>配送方式价格</td>
        <td>支付id</td>
        <td>支付名称</td>
        <td>订单金额</td>
        <td>订单状态</td>
        <td>第三方交易号</td>
        <td>创建时间</td>
        <td>操作</td>
    <tr>
    </thead>
    <tbody>
    <?php foreach($order as $row):?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['member_id']?></td>
            <td><?=$row['name']?></td>
            <td><?=$row['province']?></td>
            <td><?=$row['city']?></td>
            <td><?=$row['area']?></td>
            <td><?=$row['address']?></td>
            <td><?=$row['tel']?></td>
            <td><?=$row['delivery_id']?></td>
            <td><?=$row['delivery_name']?></td>
            <td><?=$row['delivery_price']?></td>
            <td><?=$row['payment_id']?></td>
            <td><?=$row['payment_name']?></td>
            <td><?=$row['total']?></td>
            <td><?=$row['status']==1?'未发货':'已发货'?></td>
            <td><?=$row['trade_no']?></td>
            <td><?=date('Y-m-dH:i:s',$row['create_time'])?></td>
            </td>
            <td>
                <?=\yii\bootstrap\Html::a($row['status']==1?'确定发货':'取消发货',['order/update','id'=>$row['id']],['class'=>'btn btn-warning btn-xs'])?>
                <?=\yii\bootstrap\Html::a('查看详情',['order/info','id'=>$row['id']],['class'=>'btn btn-danger btn-xs'])?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>