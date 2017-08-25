<!DOCTYPE html>
<html>
<head>
<title>商家后台管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- bootstrap -->
<link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrap.css" rel="stylesheet" />
<link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />
<!-- libraries -->
<link href="<?php echo FOOD_PATH?>css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo FOOD_PATH?>fonts/font-awesome.css" type="text/css" rel="stylesheet" />
<!-- global styles -->
<link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>css/compiled/icons.css">

<!-- this page specific styles -->
<link rel="stylesheet" href="<?php echo FOOD_PATH?>css/compiled/index.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo FOOD_PATH?>css/compiled/new-user.css" type="text/css" media="screen" />


</head>
<body>
<!-- navbar -->
<header class="navbar navbar-inverse" role="banner">
<div class="navbar-header">
    <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.html"><img src="<?php echo FOOD_PATH;?>img/logo.png"></a>
</div>
<ul class="nav navbar-nav pull-right hidden-xs">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
        欢迎你，1231
        <b class="caret"></b>
        </a>
        <!-- <ul class="dropdown-menu">
        <li><a href="personal-info.html">个人信息</a></li>
        <li><a href="#">账号设置</a></li>
        <li><a href="#">账单</a></li>
        <li><a href="#">导出数据</a></li>
        <li><a href="#">发送反馈</a></li>
        </ul> -->
    </li>

<!--    <li class="settings hidden-xs hidden-sm">
        <a href="#" role="button"><i class="icon-cog"></i></a>
    </li> -->
    <li class="settings hidden-xs hidden-sm">
        <a href="?m=plugin&p=admin&cn=index1&id=food:sit:logout" onclick="if(confirm('是否确定退出？')==false)return false;" role="button">
        <i class="icon-share-alt"></i></a>
    </li>
</ul>
</header>




   <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li class="active">
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a href="?r=plugin/stores/homepage/index">
                    <i class="icon-home"></i>
                    <span>首页</span>
                </a>
            </li>
            <li>
                <a href="?r=plugin/stores/homepage/stores_manage">
                    <i class="icon-signal"></i>
                    <span>门店管理</span>
                </a>
            </li>
             <li>
                <a href="?r=plugin/stores/homepage/company_page">
                    <i class="icon-signal"></i>
                    <span>公司首页</span>
                </a>
            </li>
            <li>
                <a href="?r=plugin/stores/homepage/order_list">
                    <i class="icon-picture"></i>
                    <span>订单中心</span>
                </a>
            </li>
            <li>
                <a href="?r=plugin/stores/homepage/stores_type">
                    <i class="icon-calendar-empty"></i>
                    <span>门店类型</span>
                </a>
            </li>
            <li>
                <a href="?r=plugin/stores/homepage/shopkeeper">
                    <!-- <i class="icon-cog"></i> -->
                     <i class="icon-group"></i>
                    <span>店长管理</span>
                </a>
            </li>
            <li>
                <a href="?r=plugin/stores/homepage/payment">
                    <!-- <i class="icon-cog"></i> -->
                     <i class="icon-tags"></i>
                    <span>支付配置</span>
                </a>
            </li>
        </ul>
    </div>
<?php echo $content;?>
<script src="<?php echo FOOD_PATH;?>js/jquery-latest.js"></script>
<script src="<?php echo FOOD_PATH;?>js/bootstrap.min.js"></script>
<script src="<?php echo FOOD_PATH;?>js/theme.js"></script>