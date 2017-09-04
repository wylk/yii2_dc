<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>修改收货地址</title>
<script>
    var csrf="<?php echo \Yii::$app->request->csrfToken;?>";
</script>
</head>
<body>
<!--头部开始-->
<div class="addrmain">
<div class="header">
    <h1>修改收货地址</h1>
    <a href="javascript:window.history.go(-1);" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<div style="height: 492px">
<input type="hidden" name="aid" value="<?php echo $data1['id']?>">
<!-- <form name="shareaddr" action="" onsubmit="" method="post"> -->
<ul class="addrul">
    <li><span>收货人</span><input type = "text" name="consignee" id="name" value="<?php echo $data1['consignee']?>"></li>
    <li><span>手机号码 </span><input type = "text" name="phone" id="phone" value="<?php echo $data1['phone']?>"></li>
    <li><span>省份</span><a class="input_province"><?php echo $data1['province']?></a>
    <select class="select" name="province" id="province" style="display: none;">
    <option value="<?php echo $data1['province']?>"></option>
    </select>
    </li>
    <li><span>市</span><a class="input_city"><?php echo $data1['city']?></a>
    <select class="select" name="city" id="city" style="display: none;">
    <option value="<?php echo $data1['city']?>"></option>
    </select></li>
    <li><span>区县</span><a class="input_town"><?php echo $data1['town']?></a>
    <select class="select" name="town" id="town" style="display: none;">
    <option value="<?php echo $data1['town']?>"></option>
    </select></li>
    <li><span>详细地址 </span><input type = "text" name="detail" id="detailed" value="<?php echo $data1['detail']?>"></li>
    <!-- <input id="address" name="address" type="hidden" value="" /> -->
    <div class="shopPay">
        <a class="shopOther" onclick="return chenkObj()"  type="submit" >提交</a>
    </div>
</ul>
<!-- </form> -->
</div>
</div>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/gen.js"></script>
