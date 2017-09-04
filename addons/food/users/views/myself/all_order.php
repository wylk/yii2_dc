<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="<?php echo FOOD_PATH;?>wap/css/order_style.css"/>
<link rel="stylesheet" href="<?php echo FOOD_PATH;?>fonts/font-awesome.min.css"/>
<title>已支付订单</title>
</head>
<body>
<div class="main">
<!--头部开始-->
<div class="header">
    <h1>已支付订单</h1>
    <a href="javascript:window.history.go(-1);" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<aside class="billmain">
<ul class="bill_list">
<?php if(!empty($data)){
    foreach($data as $v):
?>
    <li>
        <div class="billnum"><?php echo $v['shop_name']?><span class="bright"><?php
        if($v['status']==1)
        echo '未支付';
        elseif($v['status']==2)
        {
            echo '已支付';
        }elseif($v['status']==3)
        {
            echo '已完成';
        }
        ?></span></div>
         <?php foreach($data1 as $v1){
        foreach($v1 as $v2)
        {
            if($v2['order_id']==$v['id'])
            {
        ?>
        <div class="shop-info">
            <div class="shop-info-img" style="left:10px;"><a href="#"><img src="<?php echo $v2['goods_img']?>" /></a></div>
            <div class="shop-info-text">
            <h4><?php echo $v2['goods_name']?></h4>
                <div class="shop-price">
                    <div class="shop-arithmetic">
                        <strong>￥<?php echo $v2['goods_price']?></strong><br>
                        <span class="num" >×<?php echo $v2['goods_num']?></span>
                    </div>
                </div>
            </div>
        </div>
          <?php }}}?>
        <div class="sumprice">总价：￥<?php echo $v['total']?><span class="bright"><a href="#">详情</a></span></div>
    </li>
    <?php endforeach;}else{?>
    暂无数据
    <?php };?>


</ul>
</aside>
<div style="height: 8rem;"></div>
</div>
