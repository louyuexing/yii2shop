<div class="category fl"> <!-- 非首页，需要添加cat1类 -->
    <div class="cat_hd">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
        <h2>全部商品分类</h2>
        <em></em>
    </div>

    <div class="cat_bd">
         <?php foreach ($result as $key=>$row):?>
        <div class="cat <?=$key==0?'item1':''?>">
            <h3><a href=""><?=$row->name?></a><b></b></h3>
            <div class="cat_detail">
                <?php foreach ($row->children as $rs):?>
                <dl class="dl_1st">
                    <dt><a href=""><?=$rs->name?></a></dt>
                    <dd>
                        <?php foreach ($rs->children as $child):?>
                        <a href=""><?=$child->name?></a>
                        <?php endforeach;?>
                    </dd>
                </dl>
                <?php endforeach;?>
            </div>

        </div>
         <?php endforeach;?>

    </div>

</div>