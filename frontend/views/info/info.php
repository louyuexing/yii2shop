<!-- 商品概要信息 start -->
<div class="summary">
    <h3><strong><?=$good->name?></strong></h3>

<!-- 图片预览区域 start -->
<div class="preview fl">
    <div class="midpic">
        <a href="/images/preview_l1.jpg" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
            <img src="/images/preview_m1.jpg" alt="" />               <!-- 第一幅图片的中图 -->
        </a>
    </div>

    <!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

    <div class="smallpic">
        <a href="javascript:;" id="backward" class="off"></a>
        <a href="javascript:;" id="forward" class="on"></a>
        <div class="smallpic_wrap">
            <ul>
                <?php $result=\backend\models\GoodsImg::findAll(['goods_id'=>$id])?>
                <?php foreach ($result as $rs):?>
                    <li>
                        <a href="javascript:void(0);"
                           rel="{gallery: 'gal1', smallimage: 'http://admin.yii2shop.com<?=$rs->img?>',largeimage: 'http://admin.yii2shop.com<?=$rs->img?>'}">
                    <?=\yii\helpers\Html::img('http://admin.yii2shop.com'.$rs->img,['width'=>40])?></a>
                    </li>
                <?php endforeach;?>
<!--                <li class="cur">-->
<!--                    <a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '/images/preview_m1.jpg',largeimage: '/images/preview_l1.jpg'}"><img src="/images/preview_s1.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '/images/preview_m2.jpg',largeimage: '/images/preview_l2.jpg'}"><img src="/images/preview_s2.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: '/images/preview_m3.jpg',largeimage: '/images/preview_l3.jpg'}">-->
<!--                        <img src="/images/preview_s3.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: '/images/preview_m4.jpg',largeimage: '/images/preview_l4.jpg'}">-->
<!--                        <img src="/images/preview_s4.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: '/images/preview_m5.jpg',largeimage: '/images/preview_l5.jpg'}">-->
<!--                        <img src="/images/preview_s5.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: 'images/preview_m6.jpg',largeimage: 'images/preview_l6.jpg'}">-->
<!--                        <img src="images/preview_s6.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: 'images/preview_m7.jpg',largeimage: 'images/preview_l7.jpg'}">-->
<!--                        <img src="images/preview_s7.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: 'images/preview_m8.jpg',largeimage: 'images/preview_l8.jpg'}">-->
<!--                        <img src="images/preview_s8.jpg"></a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="javascript:void(0);"-->
<!--                       rel="{gallery: 'gal1', smallimage: 'images/preview_m9.jpg',largeimage: 'images/preview_l9.jpg'}">-->
<!--                        <img src="images/preview_s9.jpg"></a>-->
<!--                </li>-->
            </ul>
        </div>

    </div>
</div>
<!-- 图片预览区域 end -->

<!-- 商品基本信息区域 start -->
<div class="goodsinfo fl ml10">
    <ul>
        <li><span>商品编号： </span><?=$good->sn?></li>
        <li class="market_price"><span>定价：</span><em>￥<?=$good->shop_price?></em></li>
        <li class="shop_price"><span>本店价：</span> <strong>￥<?=$good->market_price?></strong> <a href="">(降价通知)</a></li>
        <li><span>上架时间：</span><?=date("Y-m-d",$good->create_time)?></li>
        <li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
    </ul>
    <form action="<?=\yii\helpers\Url::to(['cart/index'])?>" method="post" class="choose">
        <ul>

            <li>
                <dl>
                    <dt>购买数量：</dt>
                    <dd>
                        <a href="javascript:;" id="reduce_num"></a>
                        <input type="text" name="amount" value="1" class="amount"/>
                        <a href="javascript:;" id="add_num"></a>
                    </dd>
                </dl>
            </li>

            <li>
                <dl>
                    <dt>&nbsp;</dt>
                    <dd>
                        <input type="submit" value="" class="add_btn" />
                        <input type="hidden" name="good_id" value="<?=$good->id?>">
                        <input name="_csrf-frontend" type="hidden" id="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                    </dd>
                </dl>
            </li>

        </ul>
    </form>
</div>
<!-- 商品基本信息区域 end -->
</div>
<!-- 商品概要信息 end -->

<div style="clear:both;"></div>

<!-- 商品详情 start -->
<div class="detail">
    <div class="detail_hd">
        <ul>
            <li class="first"><span>商品介绍</span></li>
            <li class="on"><span>商品评价</span></li>
            <li><span>售后保障</span></li>
        </ul>
    </div>
    <div class="detail_bd">
        <!-- 商品介绍 start -->
        <div class="introduce detail_div none">
            <div class="attr mt15">
                <ul>
                    <li><span>商品名称：</span><?=$good->name?></li>
                    <li><span>商品编号：</span><?=$good->sn?></li>
                    <li><span>品牌：</span><?=$good->brand->name?></li>
                    <li><span>上架时间：</span><?=date("Y-m-d",$good->create_time)?></li>
                    <li><span>商品毛重：</span>2.47kg</li>
                    <li><span>商品产地：</span>中国大陆</li>
                    <li><span>显卡：</span>集成显卡</li>
                    <li><span>触控：</span>非触控</li>
                    <li><span>厚度：</span>正常厚度（>25mm）</li>
                    <li><span>处理器：</span>Intel i5</li>
                    <li><span>尺寸：</span>12英寸</li>
                </ul>
            </div>

            <div class="desc mt10">
                <!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
                <?php $result=\backend\models\GoodsImg::findAll(['goods_id'=>$id])?>
                <?php foreach ($result as $key=>$row):?>
                    <?=\yii\helpers\Html::img('http://admin.yii2shop.com'.$row->img,['width'=>600])?>
                    <?php
                    if($key==count($result)-2){
                        echo '';
                    }else{
                        echo '  <p style="height:10px;"></p>';
                    }

                    ?>
                <?php endforeach;?>
            </div>
        </div>
        <!-- 商品介绍 end -->
