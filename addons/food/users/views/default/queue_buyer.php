<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>排队</title>
<style type="text/css">
    .header{
        text-align: center;
    }
     .addrmain{width:99.99%; margin:0 auto; padding-top:10%;}

    .addrmain .addrul li{width:90%; height: 45px;}
    .addrmain .addrul li span{display: inline-block; width:25%; margin-left: 10%;}
    .addrmain .addrul li input, .addrmain .addrul li select{width:65%; border:1px solid #E0E0E0; height: 30px; }
    .addrul{
        list-style: none;
    }
    .shopPay {width:95%; margin: 0 auto;}

  .shopOther{font-weight: 600; text-align: center;width:100%; display: inline-block; line-height: 180%;  font-size: 0.5rem; color: #fff; border-radius: 4px;  background: #4CAF50; cursor: pointer;   -webkit-transition: all .1s linear; -moz-transition: all .1s linear;  transition: all .1s linear; }
   .shopOther:active {background: #4CAF50; opacity: 1; }
  .shopOther:hover {   text-decoration: none;    opacity: 0.87;    color: #fff; }


</style>
<!-- <link rel="stylesheet" href="<?php echo FOOD_PATH?>wap/css/shoppingcart.css"/> -->
</head>
<body>
<!--头部开始-->
<div class="header">
    <h3>排队</h3>
    <a href="javascript:window.history.go(-1);" class="back"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<div class="addrmain">
<form name="shareaddr" action="" onsubmit="" method="post">
<ul class="addrul">
    <li><span>手机号:</span><input type = "text" name="tel"></li>
    <li><span>用餐人数: </span><input type = "text" name="buyer_num" ></li>
    <div class="shopPay">
        <a class="shopOther" style=" font-size: 1.5rem;" type="submit" id="add">提交</a>
    </div>
</ul>
</form>
</div>

</body>
</html>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/jquery-3.2.1.min.js"></script>
<script>
$(function(){
    $('#add').click(function(){
        var tel = $("input[name='tel']").val();
        var buyer_num= $("input[name='buyer_num']").val();
        if (!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(tel))) {
            alert('手机号码格式不对');return false;
        }
        if (buyer_num.length < 1) {
            alert('用餐人数不能为空');return false;
        }
        var data ={}
        data.tel = tel;
        data.buyer_num = buyer_num;
        // console.log('ok');
        console.log(data);
        $.post("?m=plugin&p=wap&cn=index&id=food:sit:do_queue_buyer",data,function(re){
            console.log(re);
            if (re.error == 0) {
                alert(re.msg);
                console.log(re.msg);
                setTimeout(function(){
                    window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:do_queue_buyer_show'
                },1000);
            }else{
                alert(re.msg);
                console.log(re.msg);
            }
        },'json');
    });
});
</script>