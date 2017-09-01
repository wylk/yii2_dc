<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<title>点餐系统</title>

<style type="text/css">

html{color:#000;}
body{font-family:'微软雅黑','Microsoft Yahei', sans-serif; background: url(<?php echo FOOD_PATH?>img/orderbackground.jpg);}
*{padding:0; margin:0; font-size: .6em;}
a{ text-decoration:none;}

    .order_index{width: 100%; height: 100%}
    .order_index h1,h2,h3,h4,h5,h6{font-size: 100%;}
    .swiper-container { width:4rem; height:1.05rem; overflow: hidden;}
    .swiper-wrapper img{ width:4rem; height:1.0rem;}
    /*.order_index .swiper-container{margin-bottom:2%;}*/
    .order_index .con{width:3.7rem; margin:2% auto; border-radius: 3%; border:1px solid #dcdcdc;
                        -moz-box-shadow: 0px 2px 1px #888888; /* 老的 Firefox */
                        box-shadow: 0px 2px 1px #888888;
                        height:0.99rem;
                        padding:0 2%;
                        background-color: #FFF;
    }

    .order_index .con .take-out {background: url(<?php echo FOOD_PATH?>img/icon/bike.png) no-repeat left; background-size: .6rem; width:1.85rem; height:100%; float:left;}
    .order_index .con .order-self{background: url(<?php echo FOOD_PATH?>img/icon/house.png)no-repeat right;background-size: .6rem; width:1.83rem; height:100%; float:right; border-left:1px solid #dcdcdc;}
    .order_index h1{padding-top:.25rem; font-size:0.18rem;}
    .order_index span{font-size:0.15rem; color:#000; font-weight: normal; display:block;  ;}
    .order_index .con .take-out h1{color:#187adb; padding-left:35%;}
    .order_index .con .order-self h1{color:#d93035; padding-left:8%;}




    .order_index .sudoku{width:3.99rem; height:3.55rem; margin:.15rem auto; /*background: url(images/icon/sudoku_background.jpg) no-repeat 0 bottom; background-size:100%;*/ border-bottom:1px solid #dcdcdc;}
    .order_index .sudoku ul li{width:1.32rem; height:auto; float: left; text-align:center; border:0px solid #000;}
    .order_index .sudoku ul li span{display: block; height:.65rem; border:0px solid #000;}
    .order_index .sudoku ul li img{width:.55rem; margin-top:.15rem; }
    .order_index .sudoku ul li h1{font-size: 0.15rem;  padding:.15rem;}
    .order_index .sudoku ul li.s1{border-bottom: 1px solid #dcdcdc;}
    .order_index .sudoku ul li.s1 img{margin-top:.2rem;}
    .order_index .sudoku ul li.s2{border: solid #dcdcdc; border-width:0 1px 1px 1px;}
    .order_index .sudoku ul li.s2 img{margin-top:.09rem;}
    .order_index .sudoku ul li.s3{border-bottom: 1px solid #dcdcdc;}
    .order_index .sudoku ul li.s3 img{margin-top:.02rem;}
    .order_index .sudoku ul li.s4{border-bottom: 1px solid #dcdcdc;}
    .order_index .sudoku ul li.s4 img{}
    .order_index .sudoku ul li.s5{border: solid #dcdcdc; border-width:0 1px 1px 1px;}
    .order_index .sudoku ul li.s5 img{width:.49rem;}
    .order_index .sudoku ul li.s6{border-bottom: 1px solid #dcdcdc;}
    .order_index .sudoku ul li.s6 img{}
    .order_index .sudoku ul li.s7{}
    .order_index .sudoku ul li.s7 img{margin-top:.25rem;}
    .order_index .sudoku ul li.s8{border: solid #dcdcdc; border-width:0 1px;}
    .order_index .sudoku ul li.s8 img{}
    .order_index .sudoku ul li.s9{}
    .order_index .sudoku ul li.s9 img{}
    /*order_index
    .order_index
    .order_index
    .order_index
    .order_index
    .order_index
    .order_index
    .order_index
    .order_index
    .order_index .take-out*/





a:hover,a:link,a:visited,a{ color:inherit; text-decoration:none;}
ul,li{list-style:none}
footer{ position:fixed; bottom:0; width:4rem; height:0.45rem; line-height:0.45rem; background-color:#ECECEC;}
footer .ft-lt{ float:left; width:2.749rem; height:0.45rem;}
footer .ft-lt p{ float:left; margin-left:0.15rem; font-size:0.18rem;}
footer .ft-rt{ float:left; width:1.25rem; height:0.45rem; background-color:#39B867;}
footer .ft-rt p{ font-size:0.2rem; color:#fff; text-align:center;}
.jq{ width:3rem; height:0.8rem;}
</style>
</head>

<body>
<div class="order_index">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="<?php echo FOOD_PATH?>img/noodles.jpg"></div>
        </div>
    </div>
    <div class="con">
        <div class="take-out" onclick="location='#order.html'"><h1>外送<span>预计30分钟送达</span></h1></div>
        <div class="order-self" onclick="location='?r=plugin/users/default/getwx_location'"><h1>自助点餐<span>门店点餐不排队</span></h1></div>
    </div>
    <div class="sudoku">
        <ul>
            <li class="s1"><span><img src="<?php echo FOOD_PATH?>img/icon/card.png"></span><h1>会员吗</h1></li>
            <li class="s2"><span><img src="<?php echo FOOD_PATH?>img/icon/K-lo.jpg"></span><h1>K金商城</h1></li>
            <li class="s3"><span><img src="<?php echo FOOD_PATH?>img/icon/Vip.png"></span><h1>会员特权</h1></li>
            <li class="s4"><span><img src="<?php echo FOOD_PATH?>img/icon/vback.png"></span><h1>我的卡包</h1></li>
            <li class="s5"><span><img src="<?php echo FOOD_PATH?>img/icon/bill.png"></span><h1>我的订单</h1></li>
            <li class="s6"><span><img src="<?php echo FOOD_PATH?>img/icon/game.png"></span><h1>99K金小游戏</h1></li>
            <li class="s7"><span><img src="<?php echo FOOD_PATH?>img/icon/discount.png"></span><h1>优惠券</h1></li>
            <li class="s8"><span><img src="<?php echo FOOD_PATH?>img/icon/giftcard.png"></span><h1>K礼品卡</h1></li>
            <li class="s9"><span><img src="<?php echo FOOD_PATH?>img/icon/K-Music.jpg"></span><h1>K-Music</h1></li>
        </ul>

    </div>
    <div class="footer">

    </div>
</div>

</body>
</html>
<script type="text/javascript" src="<?php echo FOOD_PATH?>js/Adaptive.js"></script>