<!DOCTYPE html>
<html>
<head>
	<title>点餐后台</title>
	<meta name="keywords" content="" />
	<meta name="description" content=" " />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap -->
    <link href="<?php echo FOOD_PATH;?>css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo FOOD_PATH;?>css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="<?php echo FOOD_PATH;?>css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo FOOD_PATH;?>fonts/font-awesome.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH;?>css/compiled/layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH;?>css/compiled/elements.css">
    <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH;?>css/compiled/icons.css">
    <link rel="stylesheet" href="<?php echo FOOD_PATH?>css/compiled/new-user.css" type="text/css" media="screen" />
    <!-- this page specific styles -->
    <link rel="stylesheet" href="<?php echo FOOD_PATH;?>css/compiled/index.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo FOOD_PATH;?>sweetalert/sweetalert.css" type="text/css" media="screen" />
    <script src="<?php echo FOOD_PATH;?>sweetalert/sweetalert.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js">
    </script>
    <script src="<?php echo FOOD_PATH;?>js/bootstrap.min.js">
    </script>
    <script src="<?php echo FOOD_PATH;?>js/theme.js"></script>

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
            <a class="navbar-brand" href=""><img src="<?php echo FOOD_PATH;?>img/logo.png"></a>
        </div>
        <ul class="nav navbar-nav pull-right hidden-xs">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
                    <?php  if($session = \Yii::$app->session['employee']['truename']){echo $session = \Yii::$app->session['employee']['truename'];}else{echo $session = \Yii::$app->session['phone'];};?>
                    <b class="caret"></b>
                </a>
            <li class="settings hidden-xs hidden-sm">
                <a href="?r=plugin/publics/default/shop_out_login" role="button">
                    <i class="icon-share-alt"></i>
                </a>
            </li>
        </ul>
    </header>
<!-- menu -->
 <div id="sidebar-nav" style="padding-top: 2.8em;">  
 </div>

<!-- menu end -->

<?=$content;?>


<script type="text/javascript">
	
		var action = "<?= $this->context->action->id ?>";
		var _csrf = '<?= Yii::$app->request->csrfToken ?>';
		$('#sidebar-nav').load('?r=plugin/shops/index/left_menu',{action:action,_csrf:_csrf},function(){
			console.log('loadok');
		})

</script>
