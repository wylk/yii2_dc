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
   
        <script src="http://code.jquery.com/jquery-latest.js">
        </script>
        <script src="<?php echo FOOD_PATH;?>js/bootstrap.min.js">
        </script>
        <script src="<?php echo FOOD_PATH;?>js/theme.js"></script>
</head>
<?= $content;?>