<title>台况-首页</title>
</head>

<body>
<header>
    <h1>台 况</h1>
</header>
<br><br>
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
