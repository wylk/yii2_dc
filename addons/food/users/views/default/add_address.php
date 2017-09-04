<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>添加收货地址</title>
<script>
    var csrf="<?php echo \Yii::$app->request->csrfToken;?>";
</script>
</head>
<body onload="setup(); preselect('北京市');">
<div class="addrmain">
<!--头部开始-->
<div class="header">
    <h1>添加收货地址</h1>
    <a href="javascript:window.history.go(-1);" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<div style="height: 492px">
<!-- <form name="shareaddr" action="" onsubmit="" method="post"> -->
<ul class="addrul">
    <li><span>收货人</span><input type = "text" name="consignee" id="name"></li>
    <li><span>手机号码 </span><input type = "text" name="phone" id="phone"></li>
    <li><span>省份</span><select class="select" name="province" id="province">
    <option></option>
    </select></li>
    <li><span>市</span><select class="select" name="city" id="city">
    <option></option>
    </select></li>
    <li><span>区县</span><select class="select" name="town" id="town">
    <option></option>
    </select></li>
    <li><span>详细地址 </span><input type = "text" name="detail" id="detailed"></li>
    <!-- <input id="address" name="address" type="hidden" value="" /> -->
    <div class="shopPay">
        <a class="shopOther" onclick="return chenkObj()"  type="submit" >提交</a>
    </div>
</ul>
<!-- </form> -->
</div>
</div>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/gen.js"></script>