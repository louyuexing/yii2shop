<div class="goodslist mt10">
    <ul>
        <?php foreach ($cates as $good):?>
        <li>
            <dl>

                <dt><?=\yii\helpers\Html::a(\yii\helpers\Html::img('http://admin.yii2shop.com'.$good->logo),['info/info','id'=>$good->id])?></dt>
                <dt><?php
              $intro=\backend\models\GoodsIntro::findOne(['goods_id'=>$good->id]);
              echo \yii\helpers\Html::a($intro['content'],['info/info','id'=>$good->id]);
                ?>
                </dt>
                <dd><strong><?=$good->shop_price?></strong></dt>
                <dd><a href=""><em>已有10人评价</em></a></dt>
            </dl>
        </li>
         <?php endforeach;?>
    </ul>
</div>

<?php
//分页工具条
//echo \yii\widgets\LinkPager::widget([
//    'pagination'=>$page,
//    'nextPageLabel'=>'下一页',
//    'prevPageLabel'=>'上一页',
//
//]);
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page,
    'nextPageLabel'=>'下一页',
    'prevPageLabel'=>'上一页'

]);