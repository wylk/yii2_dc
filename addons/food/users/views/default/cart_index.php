<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>点餐系统购物车</title>
</head>
<body>
<div class="main">
<!--头部开始-->
<div class="header">
    <h1>购物车</h1>
    <a href="#" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
    <div class="shop-group-item">
        <div class="shop-name">
            <input type="checkbox" class="check goods-check shopCheck">
            <h4><a href="#"><?php echo $data1['shop_name']?></a></h4>
            <div class="coupons">
                <span class="edit" onclick="hidden_del()">编辑</span>
                <span class="finish" onclick="finish_edit()" style="display:none">完成</span>
            </div>
        </div>
        <ul>
        <?php if(!empty($data))
        {
            foreach($data as $v):
        ?>
            <li>
                <div class="shop-info">
                    <input type="checkbox" class="check goods-check goodsCheck" name="goodsCheck" value="<?php echo $v['id'];?>">
                    <div class="shop-info-img"><a href="#"><img src="<?php echo $v['goods_img']?>" /></a></div>
                    <div class="shop-info-text">
                        <h4><?php echo $v['goods_name']?></h4>
                        <div class="shop-brief"><?php echo $v['cat_name']?></div>
                        <div class="shop-price">
                            <div class="shop-pices">￥<b class="price"><?php echo $v['goods_price']?></b></div>
                            <div class="shop-arithmetic">
                                <a href="javascript:;" class="minus"  data-id="<?php echo $v['goods_id']?>" price="<?php echo $v['goods_price']?>" disabled="true"></a>
                                <span class="num" ><?php echo $v['num']?></span>
                                <span class="goods_id" style="display:none"><?php echo $v['goods_id']?></span>
                                <a href="javascript:;" class="plus" data-id="<?php echo $v['goods_id']?>" price="<?php echo $v['goods_price']?>"></a>
                                <div class="delete_box f_right" style="display: none">
                                    <span class="delete_up"></span>
                                    <span class="delete_down"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </li>

            <?php endforeach;}else{?>
                <div style="height: 100px; line-height: 100px; text-align: center;">
                没有点餐呢，<a href="index.php?m=plugin&p=wap&cn=index&id=food:sit:test" class="nobill">赶紧点餐吧</a>
                </div>
            <?php };?>
        </ul>
        <div class="shopPrice">总计：￥<span class="shop-total-amount ShopTotal">0.00</span></div>
        <div class="shopNum" style="display:none"><span class="shop-total-amount Shopnum">0</span></div>
    </div>


<div class="payment-bar">
    <div class="all-checkbox"><input type="checkbox" class="check goods-check" id="AllCheck">全选</div>
    <div class="shop-total">
        <strong>总价：<i class="total" id="AllTotal">0.00</i></strong>
        <strong>数量：<i class="total" id="allnum">0</i></strong>
    </div>
    <a href="#" class="settlement">结算</a>
</div>
</div>
<div class="jd_win">
    <div class="jd_win_box">
        <div class="jd_win_tit">你确定删除该商品吗？</div>
        <div class="jd_btn clearfix">
            <a href="#" class="cancle f_left">取消</a>
            <a href="#" class="submit f_right">确定</a>
        </div>
    </div>
</div>

<style type="text/css">

.nobill{ animation: change 1s  ease-in  infinite ; font-size: 30px; color:#f00; font-weight: bold}
        @keyframes change {
            0%{ text-shadow: 0 0 5px #059}
            50%{ text-shadow: 0 0 50px #f00}
            100%{ text-shadow: 0 0 5px #123}

</style>