
<div class="content">
	<ul class="desk">
	<?php if(!empty($data1)){?>
		<?php foreach($data1 as $v){?>
        	<li><a href="r=plugin/shops/index/wap_menuorder&shop_id=<?php echo $mid?>&table_id=<?php echo $v['id']?>&eid=<?php echo $_SESSION['employee']['id']?>" onclick = "document.getElementById('open').style.display='block';document.getElementById('operate').style.display='block'" class="unused"><p class="use_txt">空台</p></a><p class="d_num"><?php echo $v['title']?></p></li>
        <?php } ?>
    <?php }else{?>
        	暂无数据
    <?php };?>

    </ul>
</div>
</body>
</html>