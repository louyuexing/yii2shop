<table class="table table-bordered">
    <thead>
    <tr>
        <td>id</td>
        <td>订单id</td>
        <td>商品id</td>
        <td>商品名称</td>
        <td>图片</td>
        <td>价格</td>
        <td>数量</td>
        <td>小计</td>

    <tr>
    </thead>
    <tbody>
    <?php foreach($result as $row):?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['order_id']?></td>
            <td><?=$row['goods_id']?></td>
            <td><?=$row['goods_name']?></td>
            <td><?=\yii\bootstrap\Html::img($row['logo'],['height'=>40])?></td>
            <td><?=$row['price']?></td>
            <td><?=$row['amount']?></td>
            <td><?=$row['total']?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>