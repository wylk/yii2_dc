<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>管理收货地址</title>

</head>
<body>

<div class="main">
<!--头部开始-->
<div class="header">
    <h1>管理收货地址</h1>
    <a href="javascript:window.history.go(-1);" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<div style="height: 524px">
<ul class="addrul">
    <?php
    if(!empty($data))
    {
        foreach($data as $v):
    ?>
    <li><div class="address">
        <div class="ad_le">
            <div class="addr"><?php echo $v['province']?><?php echo $v['city']?><?php echo $v['town']?><?php echo $v['detail']?></div>
            <div class="name"><b><?php echo $v['consignee']?></b><?php echo $v['phone']?>
            <?php if($v['is_default']==1):?>
            <a style="color:red;float:right;">默认地址</a>
            <?php else:?>
            <a href="?r=plugin/users/default/edit_default&aid=<?php echo $v['id']?>" onclick="if(confirm('是否确定使用该地址？')==false)return false;" style="color:red;float:right;">使用该地址</a>
            <?php endif;?>
            </div>
        </div>
            <div class="delete_box ad_ri">
                <a class="addr_edit" href="?r=plugin/users/default/edit_address&aid=<?php echo $v['id']?>"></a>
                <span style="display:none"><?php echo $v['id']?></span>
                <a class="addr_del" data-id="<?php echo $v['id']?>">删除</a>
            </div>
        </div>
    </li>
<?php endforeach;}else{?>
    暂无数据
    <?php };?>
</ul>
<div class="addrplus"><a href="?r=plugin/users/default/add_address">新增收货地址</a></div>
</div>
</div>
<div class="ajd_win">
    <div class="ajd_win_box">
        <div class="ajd_win_tit">你确定删除该地址吗？</div>
        <div class="ajd_btn clearfix">
            <a href="#" class="acancle f_left">取消</a>
            <a href="#" class="asubmit f_right">确定</a>
        </div>

    </div>
</div>
