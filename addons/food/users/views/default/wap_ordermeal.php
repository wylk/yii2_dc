<title>快速点餐</title>
</head>

<body>
<header>
    <a href="#" class="return"><img src="<?php echo FOOD_PATH;?>img/return.png" /></a>
    <p class="switch">
    <a href="?r=plugin/users/default/wap_ordermeal&shop_id=<?php echo $mid; ?>&table_id=<?php echo isset($table_id)?$table_id:0; ?>" class="selected">快速点餐</a>
    <a href="?r=plugin/users/default/wap_menuorder&shop_id=<?php echo $mid; ?>&table_id=<?php echo isset($table_id)?$table_id:0; ?>">菜谱点餐</a></p>
</header>
<a href="My menu.html" class="amount">
    已点<span>3</span>
</a>
<div class="content">
        <ul class="menu">
            <li>
                <img src="<?php echo FOOD_PATH;?>img/food_01.png"/>
                <h4>梅菜扣肉</h4>
                <p class="price">28.0元/份</p>
                <p class="discount"><span>折扣价</span>26.0元/份</p>
                <a href="#" class="add"><img src="<?php echo FOOD_PATH;?>img/add.png" /></a>
           </li>
        </ul>
    </div>
<div class="footer-space"></div>
