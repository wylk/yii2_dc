<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>领号排队</title>
    <style type="text/css">
        *{padding:0; margin: 0; list-style: none; font-size: 1rem;}
        /*头部开始*/
        .header{position:relative;width:100%;height:44px;background:#fff;margin-bottom:1px;}
        .header h1{font-size:16px;color:#333;height:44px;line-height:44px;display:block;text-align:center; font-weight: normal;}
        .header a{position: absolute;top:0;display:block;height:44px;line-height:44px;}
        .header a.back{left:0px;}
        .header a.back span{display:inline-block;width:25px;height:25px;margin:10px 5px;background: url("images/icon/icon-back.png") no-repeat;background-size:100%;}
        /*头部结束*/

        html{width:100%; background: url(<?php echo FOOD_PATH?>wap/img/313.jpg) no-repeat; background-size:100% 100%;  height: 100%; }
        main{ margin: 0 auto;}/*设置居中*/
        .main{text-align: center; padding:35px 0; background: #FFF; width:100%; filter:alpha(Opacity=60);-moz-opacity:0.6;opacity: 0.6;}
        /*//设置透明度为60%*/
        .minor{margin-top:35px; float: left;}
        .minor li{height: 35px; line-height: 35px; border: 1px solid #E0E0E0; float: left; margin: 1% 2%; padding:0 2%; width: 100%; font-size:0.8rem; background: #FFF; }
        .minor li span{float: right; color: #FF0000 }
        /* 定义keyframe动画，命名为blink */
        @keyframes blink{0%{opacity: 1;}50%{opacity: 1;}50.01%{opacity: 0;} /* 注意这里定义50.01%立刻透明度为０，可以设置闪烁效果 */100%{opacity: 0;} }
        /* 添加兼容性前缀 */
        @-webkit-keyframes blink {  0% { opacity: 1; }  50% { opacity: 1; }  50.01% { opacity: 0; }  100% { opacity: 0; }}

        @-moz-keyframes blink {  0% { opacity: 1; }  50% { opacity: 1; }  50.01% { opacity: 0; }  100% { opacity: 0; }}

        @-ms-keyframes blink {  0% { opacity: 1; }  50% { opacity: 1; }  50.01% { opacity: 0; }  100% { opacity: 0; }}

        @-o-keyframes blink {  0% { opacity: 1; }  50% { opacity: 1; }  50.01% { opacity: 0; }  100% { opacity: 0; }}
        /* 定义blink类*/
        .blink{  animation: blink .05s linear infinite;    /* 其它浏览器兼容性前缀 */  -webkit-animation: blink .75s linear infinite;  -moz-animation: blink .75s linear infinite;  -ms-animation: blink .75s linear infinite;  -o-animation: blink .75s linear infinite;}
    </style>
</head>
<body>
<!--头部开始-->
<div class="header">  <h1>领号排队等待</h1>  <a href="javascript:window.history.go(-1);" class="back"><span></span></a>  <a href="#" class=""></a>
</div>
<!--头部结束-->
<main>
    <div class="main"><h1>前面有<span style="color: red" class="blink"><?php if($num){echo    $num;}else{echo '0';} ?></span>人在等候</h1>
        <span style="display: block;margin-top: 10px;color:red;font-size: 12px;">你的号是:<?php echo $buyer['buyer_id'];?> &nbsp;&nbsp;<?php if($buyer['status'] == 1){echo '等待';}else if($buyer['status'] == 2){ echo '排队成功,你的桌号是'.$shop_tables['title'];}?></span>
    </div>
    <ul class="minor">
    <?php if($buyers){?>
        <?php foreach($buyers as $v){?>
        <li><?php echo $v['buyer_id'];?><span>在等待</span></li>
        <?php }?>
        <?php }else{?>
        没有人排队
        <?php }?>
    </ul>
</main>
</body>
</html>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>wap/js/jquery-3.2.1.min.js"></script>
<script>
  window.setInterval("queue()",1000);
  function queue()
  {
    $.ajax({
          url: "http://dc.51ao.com/?m=plugin&p=wap&cn=index&id=food:sit:do_queue_buyer_times",
          type: "GET",
          dataType: "json",

        });
    window.location.reload();
  }
</script>
