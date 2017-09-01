<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo FOOD_PATH?>css/reset.css" type="text/css"  rel="stylesheet" />
<link href="<?php echo FOOD_PATH?>css/style.css" type="text/css"  rel="stylesheet" />
<title>台况-首页</title>
</head>

<body>
<header>
    <h1>台 况</h1>
</header>
<div class="content">
    <ul class="desk">
    <?php if(!empty($data1))
    {
        foreach($data1 as $v):
    ?>
        <li><a href="?r=plugin/users/default/wap_menuorder&shop_id=<?php echo $mid;?>&table_id=<?php echo $v['id']?>" onclick = "document.getElementById('open').style.display='block';document.getElementById('operate').style.display='block'" class="unused"><p class="use_txt">空台</p></a><p class="d_num"><?php echo $v['title']?></p></li>
         <?php endforeach;}else{?>
            暂无数据
        <?php };?>
    </ul>
</div>

<div class="footer-space"></div>
<footer>
    <ul>
        <li><a href="?m=plugin&p=wap&cn=index&id=food:sit:choose_table&shop_id=<?php echo $mid;?>">
        <img src="<?php echo FOOD_PATH?>img/footer_1.png" /><p class="cur">台 况</p></a></li>

        <li><a href="?m=plugin&p=wap&cn=index&id=food:sit:wap_bill&shop_id=<?php echo $mid;?>">
        <img src="<?php echo FOOD_PATH?>img/footer_02.png" /><p>账 单</p></a></li>

        <li><a href="?m=plugin&p=wap&cn=index&id=food:sit:wap_callout&shop_id=<?php echo $mid;?>">
        <img src="<?php echo FOOD_PATH?>img/footer_03.png" /><p>呼 叫</p></a></li>

        <li><a href="?m=plugin&p=wap&cn=index&id=food:sit:wap_more&shop_id=<?php echo $mid;?>">
        <img src="<?php echo FOOD_PATH?>img/footer_04.png" /><p>更 多</p></a></li>
    </ul>
</footer>
</body>
</html>
