
<title>更多</title>
</head>

<body>
<header>
    <a href="javascript:window.history.go(-1);" class="return"><img src="<?php echo FOOD_PATH?>img/return.png" /></a>
    <h1>更  多</h1></p>
</header>

<br><br>
<div class="content">
   <!--  <ul class="moreSet"> -->
       <!--  <li><a href="javascript:window.location.reload();" class="blue_btn">刷新全部</a></li> --><!--<li><a href="#" class="orange_btn">会员查询</a></li>--><!-- <li><a href="#" class="green_btn">查看预约</a></li> --><!--<li><a href="#" class="gray_btn">排队人数</a>--><!-- </li> -->
    <!-- </ul> -->

<ul class="infor">
    <li class="hotel"><a href="<?php echo yii\helpers\Url::to(['myself/paid'])?>">已支付订单<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="waiter"><a href="<?php echo yii\helpers\Url::to(['myself/unpay'])?>">未支付订单<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
 <!--   <li class="food"><a href="#">菜品设置<img src="img/open.png"></a></li>-->
    <li class="password"><a href="<?php echo yii\helpers\Url::to(['myself/all_order'])?>">全部订单<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="exit"><a href="<?php echo yii\helpers\Url::to(['myself/cart_list'])?>">购物车<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="password"><a href="<?php echo yii\helpers\Url::to(['default/address_list'])?>">收货地址<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
</ul>
<!-- <ul class="infor">
    <li class="hotel"><a href="#">饭店信息<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="waiter"><a href="#l">服务员信息<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="food"><a href="#">菜品设置<img src="img/open.png"></a></li>
    <li class="password"><a href="#">修改密码<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
    <li class="exit"><a href="#">退出登录<img src="<?php echo FOOD_PATH?>img/open.png"></a></li>
</ul> -->

</div>
<div class="footer-space"></div>

