<div style="clear:both;"></div>

<!-- 页面头部 start -->
<div class="header w990 bc mt15">
    <div class="logo w990">
        <h2 class="fl"><a href="index.html"><img src="images/logo.png" alt="京西商城"></a></h2>
        <div class="flow fr flow2">
            <ul>
                <li>1.我的购物车</li>
                <li class="cur">2.填写核对订单信息</li>
                <li>3.成功提交订单</li>
            </ul>
        </div>
    </div>
</div>
<!-- 页面头部 end -->

<div style="clear:both;"></div>

<!-- 主体部分 start -->
<div class="fillin w990 bc mt15">
    <div class="fillin_hd">
        <h2>填写并核对订单信息</h2>
    </div>
    <?=\yii\helpers\Html::beginForm(['cart/create'],'post')?>
    <div class="fillin_bd">
        <!-- 收货人信息  start-->
        <div class="address">
            <h3>收货人信息</h3>
            <div class="address_info">
<!--                  --><?php //if($addresses==null){
//
//                      throw new \yii\web\NotFoundHttpException('没有收货地址');
//                  }?>
                <?php foreach ($address_all as $address):?>
                    <P><?=\yii\helpers\Html::input('radio','address_id',$address->id,['checked'=>$address->status?'checked':''])?><?php echo $address->id.'--',$address->name.'--',$address->phone.'--',$address->address($address->provinces),'--',$address->address($address->city).'--',$address->address($address->area).'--',$address->addressinfo.'--'?></P>
                <?php endforeach;?>
            </div>


        </div>
        <!-- 收货人信息  end-->

        <!-- 配送方式 start -->
        <div class="delivery">
            <h3>送货方式 </h3>


            <div class="delivery_select">
                <table>
                    <thead>
                    <tr>
                        <th class="col1">送货方式</th>
                        <th class="col2">运费</th>
                        <th class="col3">运费标准</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $addresses=\frontend\models\Order::$delivery;
                    foreach ($addresses as $key=>$address):?>
                    <tr class="<?=$key==count($addresses)-1?'cur':''?>">
                        <td><input type="radio" name="delivery" class="addre" checked="<?=$key==0?'checked':''?>" value="<?=$address['delivery_id']?>"/><?=$address['delivery_name']?>
                        </td>
                        <td class="d_price">￥<span><?=$address['delivery_price']?></span></td>
                        <td>每张订单不满499.00元,运费15.00元, 订单4...</td>
                    </tr>
                    <?php endforeach;?>

                    </tbody>
                </table>

            </div>
        </div>
        <!-- 配送方式 end -->

        <!-- 支付方式  start-->
        <div class="pay">
            <h3>支付方式 </h3>


            <div class="pay_select">
                <table>
                    <?php $payment=\frontend\models\Order::$payment;
                    foreach ($payment as $key=>$pay):
                    ?>
                    <tr class="<?=$key==count($payment)-1?'cur':''?>">
                        <td class="col1"><input type="radio" name="pay" checked="<?=$key==0?'checked':''?>" value="<?=$pay['payment_id']?>" /><?=$pay['payment_name']?></td>
                        <td class="col2"><?=$pay['intro']?></td>
                    </tr>
                    <?php endforeach;?>

                </table>

            </div>
        </div>
        <!-- 支付方式  end-->

        <!-- 发票信息 start-->

        <!-- 发票信息 end-->

        <!-- 商品清单 start -->
        <div class="goods">
            <h3>商品清单</h3>
            <table>
                <thead>
                <tr>
                    <th class="col1">商品</th>
                    <th class="col3">价格</th>
                    <th class="col4">数量</th>
                    <th class="col5">小计</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($goods as $good):?>
                <tr>
                    <td class="col1"><a href=""><?=\yii\helpers\Html::img('http://admin.yii2shop.com'.$good['logo'])?></a>  <strong><a href=""><?$good['name']?></a></strong></td>
                    <td class="col3">￥<?=$good['shop_price']?></td>
                    <td class="col4"><?=$good['amount']?></td>
                    <td class="col5">￥<span><?=$good['shop_price']*$good['amount']?></span></td>
                </tr>
                <?php endforeach;?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <ul>
                            <li>
                                <span><?=count($goods)?>件商品，总商品金额：</span>
                                <em class="count_price">￥<span>5316.00</span></em>
                            </li>
                            <li>
                                <span>返现：</span>
                                <em class="back_m">￥<span>240.00</span></em>
                            </li>
                            <li>
                                <span>运费：</span>
                                <em class="delivery_price">￥<span>10.00</span></em>
                            </li>
                            <li>
                                <span>应付总额：</span>
                                <em>￥<span class="pay_count">5076.00</span></em>
                            </li>
                        </ul>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- 商品清单 end -->

    </div>
      <input type="hidden" name="total" class="t_count">
    <div class="fillin_ft">
        <?=\yii\helpers\Html::submitButton(\yii\helpers\Html::a('<span>提交订单</span>'),['class'=>'submit','height'=>20,'width'=>90])?>
        <?=\yii\helpers\Html::endForm()?>
        <p>应付总额：<strong>￥<span class="last_count">5076.00</span>元</strong></p>

    </div>
</div>
<!-- 主体部分 end -->

<div style="clear:both;"></div>
<!-- 底部版权 start -->
<div class="footer w1210 bc mt15">
    <p class="links">
        <a href="">关于我们</a> |
        <a href="">联系我们</a> |
        <a href="">人才招聘</a> |
        <a href="">商家入驻</a> |
        <a href="">千寻网</a> |
        <a href="">奢侈品网</a> |
        <a href="">广告服务</a> |
        <a href="">移动终端</a> |
        <a href="">友情链接</a> |
        <a href="">销售联盟</a> |
        <a href="">京西论坛</a>
    </p>
    <p class="copyright">
        © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
    </p>
    <p class="auth">
        <a href=""><img src="images/xin.png" alt="" /></a>
        <a href=""><img src="images/kexin.jpg" alt="" /></a>
        <a href=""><img src="images/police.jpg" alt="" /></a>
        <a href=""><img src="images/beian.gif" alt="" /></a>
    </p>
</div>
<!-- 底部版权 end -->
</body>
</html>

<?php
/**
 * @var $this \yii\web\View
 */
$address_all=count($address_all);
$this->registerJs(new \yii\web\JsExpression(
        <<<JS
      $('.addre').click(function(){
        
          var t=Number($(this).closest('tr').find('.d_price').find('span').text());
          $('.delivery_price').find('span').text(t);
         var count_price= Number($('.count_price').text());
         var back_m =Number($('.back_m').find('span').text());
         
     
          $('.pay_count').text(count_price-back_m+t);
          $('.last_count').text(count_price-back_m+t);
          console.debug($('.count_price').text(),back_m,t)
         
      });
       
      $(function(){
          var count=$(this).find('.col5').find('span');
         var price=0;
         $(count).each(function(i,v) {
          price+=Number($(v).text());
         }) 
          price=price.toFixed(2);
         $('.count_price').text(price);
          var back_m= $('.back_m').find('span').text();
          var delivery_price=Number($('.delivery_price').find('span').text());
          $('.pay_count').text((price-back_m+delivery_price).toFixed(2));
          $('.fillin_ft').find('strong').find('span').text((price-back_m+delivery_price).toFixed(2));
          $('.t_count').val((price-back_m+delivery_price));
          var addre='$address_all'
           console.debug(addre,1);
           if(addre==0){
                $('.submit').hide();
               //   $('.submit').attr("href",'javascript:');
                if(confirm('没有收货地址添加---->点击确定')){
                    window.location.href = 'http://www.yii2shop.com/address/index.html';
                }
           }
      });
      
      
     
JS

))


?>
