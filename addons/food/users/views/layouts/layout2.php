<h1></h1><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo FOOD_PATH?>css/reset.css" type="text/css"  rel="stylesheet" />
<link href="<?php echo FOOD_PATH?>css/style.css" type="text/css"  rel="stylesheet" />
<style type="text/css">
    body{margin:0; padding:0;}
</style>

<?php echo $content;?>
<!-- <div id="mint" style="">
</div> -->
<footer>
    <ul>
        <li><a href="?r=plugin/users/default/choosetable&shop_id=<?php echo $this->params['mid'];?>">
        <img src="<?php echo FOOD_PATH?>img/footer_1.png" /><p class="cur">台 况</p></a></li>

        <li><a href="?r=plugin/users/default/wap_bill&shop_id=<?php echo $this->params['mid'];?>">
        <img src="<?php echo FOOD_PATH?>img/footer_02.png" /><p>账 单</p></a></li>

        <li><a href="?r=plugin/users/default/wap_callout&shop_id=<?php echo $this->params['mid'];?>">
        <img src="<?php echo FOOD_PATH?>img/footer_03.png" /><p>呼 叫</p></a></li>

        <li><a href="?r=plugin/users/default/wap_more&shop_id=<?php echo $this->params['mid'];?>">
        <img src="<?php echo FOOD_PATH?>img/footer_04.png" /><p>更 多</p></a></li>
    </ul>
</footer>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>wap/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>wap/js/order-jquery.js?ver=12"></script>

</body>
</html>