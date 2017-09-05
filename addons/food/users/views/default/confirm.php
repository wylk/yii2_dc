<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>点餐系统购物车</title>
<style type="text/css">
*{margin:0; padding:0; list-style:none;}
body{font-family:SimHei,'Helvetica Neue',Arial,'Droid Sans',sans-serif;font-size:14px;color:#333;background:#efefef;}
a, a.link{color:#666;text-decoration:none;font-weight:500;}
a, a.link:hover{color:#666;}

/*头部开始*/
.header{position:relative;width:100%;height:44px;border-bottom:1px solid #e0e0e0;}
.header h1{font-size:16px;color:#333;height:44px;line-height:44px;display:block;text-align:center;}
.header a{position: absolute;top:0;display:block;height:44px;line-height:44px;}
.header a.back{left:0px;}
.header a.back span{display:inline-block;width:25px;height:25px;margin:10px 5px;background: url("<?php echo FOOD_PATH?>wap/images/icon/icon-back.png") no-repeat;background-size:100%;}
.header .home{}
/*头部结束*/

.shopping{clear:both;overflow:hidden;height:auto;padding-bottom: 60px;}
.shop-group-item{margin-bottom:5px;}

.shop-group-item ul li{border-bottom:1px solid #e0e0e0;}
/*.shop-group-item .buyerMessage{color:#888; height: 35px; width:100%; background: #FFF; border-bottom:1px solid #e0e0e0; padding-left: 3%; line-height: 250%;}*/
.shop-group-item textarea{width:90%; height: auto; border:0px solid #e0e0e0; padding:1% 5%; margin:;  color:#333;}
.shop-name{background:#fff;height:35px;line-height:35px;padding:0 1px;position:relative;}
.shop-name h4{float:left;font-size:14px;background:url(<?php echo FOOD_PATH?>wap/images/icon/icon-kin.png) no-repeat left center;background-size:20px 22px;padding-left:25px;margin-left: 5px;}

.shop-info{background:#f5f5f5;height:100px;padding:0 15px;position:relative;}
.shop-info .shop-info-img{position:absolute;top:10px;left:25px;width:80px;height:80px;}
.shop-info .shop-info-img img{width:100%;height:100%;}
.shop-info .shop-info-text{margin-left:110px;padding:15px 0;}
.shop-info .shop-info-text h4{font-size:14px;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow: hidden;}
.shop-info .shop-info-text .shop-price{height:24px;line-height:24px;position:relative;}
.shop-info .shop-info-text .shop-arithmetic{position:absolute;right:0px;top:-20px;width:84px;box-sizing:border-box;white-space:nowrap;height:100%; text-align: right;}
.shop-info .shop-info-text .shop-arithmetic .num{color:#999;}

.shopPrice{background:#fff;height:35px;line-height:35px;padding:0 15px;text-align:right;}
.shopPrice span{color:#ff6600;}

.shopPay {width:95%; margin: 0 auto;}

  .weixinPay, .shopOther{font-weight: 600; text-align: center;width:100%;
  display: inline-block; line-height: 280%;  font-size: 1rem; color: #fff;  font-weight: 500;  border-radius: 4px;  background: #06bf04;
  border: 1px solid #7ea13d; cursor: pointer;   -webkit-transition: all .1s linear; -moz-transition: all .1s linear;  transition: all .1s linear; }
   .weixinPay:active {
    -webkit-box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.3) inset;
    -moz-box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.3) inset;
    box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.3) inset;
    background: #30628b;
    opacity: 1; }
  .weixinPay:hover {   text-decoration: none;    opacity: 0.87;    color: #fff; }
  .shopOther{color: #333;  background: #FFF;  border: 1px solid #ccc; margin-top:5px; }

  .jd_win{width: 100%;height: 100%;position: fixed;top:0;left:0;background: rgba(0, 0, 0, 0.6);z-index: 9999;display:none;}
  .jd_win_box{width: 80%;padding: 0 10px;border-radius: 4px;background-color: #fff;position: absolute;top:50%;left:50%;transform:translate(-50%, -50%);-webkit-transform:translate(-50%, -50%);}

  </style>
  <link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH?>sweetalert/sweetalert.css">
</head>
<body>

<!--头部开始-->
<div class="header">
    <h1>未付款订单</h1>
    <a href="#" class="back" onclick="window.history.go(-1)"><span></span></a>
    <a href="#" class=""></a>
</div>
<!--头部结束-->
<div class="shopping">
    <div class="shop-group-item">
        <div class="shop-name">
            <h4><a href="#"><?php echo $shop['shop_name']?></a></h4>
        </div>
        <ul>
            <?php
            if(!empty($data1))
            {
                foreach($data1 as $v):
            ?>
            <li>
                <div class="shop-info">
                    <div class="shop-info-img"><a href="#"><img src="<?php echo $v['goods_img']?>" /></a></div>
                    <div class="shop-info-text">
                        <h4><?php echo $v['goods_name']?></h4>
                        <div class="shop-price">
                            <div class="shop-arithmetic">
                                <strong>￥<?php echo $v['goods_price']?></strong><br>
                                <span class="num" >×<?php echo $v['goods_num']?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach;}else{?>
                暂无数据
            <?php };?>
        </ul>

        <?php if($_SESSION['not_shop'] && $return1==''):?>
        <div style="text-align:center">
           <a href="?r=plugin/users/default/add_address"><img src="<?php echo FOOD_PATH?>wap/images/icon/up.png" alt="">
           <span style="color:red;position: relative;top: -7px;left: 0px;">你还没有添加收货地址，点击添加</span></a>
        </div>
    <?php elseif($_SESSION['not_shop'] && $return1):?>
        <div style="text-align:center;    background-color: #ccc;color: blue;">
            收货人：<?php echo $return1['consignee']?>,手机号：<?php echo $return1['phone']?><br>
            收货地址：<?php echo $return1['province']?><?php echo $return1['city']?><?php echo $return1['town']?><?php echo $return1['detail']?>
            &nbsp;&nbsp;&nbsp;
            <a href="?m=plugin&p=wap&cn=index&id=food:sit:address_list"><img src="<?php echo FOOD_PATH?>/wap/images/icon/edit.png" alt=""></a>
        </div>
      <?php elseif(empty($_SESSION['not_shop']) && $return1):?>

    <?php endif;?>
        <textarea name="remark" id="remark" cols="" rows="" onfocus="if ($.trim(value) =='添加备注'){value =''}" onblur="if ($.trim(value) ==''){value='添加备注'}">
        添加备注
        </textarea>



        <div class="shopPrice">总计：￥<span class="shop-total-amount ShopTotal"><?php echo $data2['total']?></span></div>
    </div>
    <div class="shopPay">
        <a class="weixinPay" id="weixinPay">微信支付</a>

    </div>

  <?php if(isset($eid)){?>

  <div class="shopPay" >
    <a class="weixinPay" style="margin-top: 35px;background: #007cff;" id="aliPay">支付宝支付</a>
  </div>

  <?php }?>

<div class="jd_win">
  <div class="jd_win_box cancle" id="qr-code-autopay" style="padding:15px;"></div>
</div>

</div>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>wap/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH;?>wap/js/jquery.qrcode.min.js"></script>
<?php if(isset($eid)):?>
<script>
  var f=window.setInterval("paystatus()",1000);
  function paystatus()
  {
    $.ajax({
          url: "?r=plugin/users/default/paystatus",
          type: "GET",
          dataType: "json",
          // async:true,
          data:{"oid":'<?php echo $data2['id']?>'},
          success: function(res){
            if(res.msg==2)
            {
                swal({
                  title: "支付成功",
                  text: '<br/>3秒后自动关闭。',
                  imageUrl: "<?php echo FOOD_PATH?>wap/images/thumbs-up.jpg",
                  html: true,
                  timer: 3000,
                  showConfirmButton: false
                });
                window.clearInterval(f);
                setTimeout("location.href='?m=plugin&p=wap&cn=index&id=food:sit:choose_table'", 1000);

            }
          }

        });
  }
</script>
<?php else:?>

<?php endif;?>
<script>
    $(function(){
        $('#weixinPay').click(function(){
             var address="<?php echo $return1['id']?>";
             var not_shop="<?php echo $_SESSION['not_shop'];?>";
             var eid="<?php echo isset($eid)?$eid:0?>"
            if(address=='' && not_shop && eid=='')
            {
                alert('你还没有添加收货地址，请添加');
                window.location.href='?r=plugin/users/default/add_address';
                return false;
            }
            var a1=$.trim($("#remark").val());
            var order_id="<?php echo $data2['id']?>";
            // var total="<?php echo $data2['total']?>";
            // var shop_name="<?php echo $shop['shop_name']?>";
            // var openid="oIXPDwozTo_z-QNATZWhDGEWpwU0";
            var postData={remark:a1};
            postData.order_id=order_id;
            // console.log(postData);
            postData.address="<?php echo $return1['province']?><?php echo $return1['city']?><?php echo $return1['town']?><?php echo $return1['detail']?>";
            postData.address_user="<?php echo $return1['consignee']?>";
            postData.address_tel="<?php echo $return1['phone']?>";
            console.log(postData);
            // return false;
            $.post('?r=plugin/users/default/confirmpay',postData,function(re){
               console.log(re);
                if(re.error == 1) {
                  alert(re.msg);
                    console.log(re.msg);

                }else if(re.error == 2){
                /*var that;*/
                $("#qr-code-autopay").empty();
                var str = toUtf8(re.msg);
                $("#qr-code-autopay").qrcode({
                    //render: "table",
                    text: re.msg
                });
                    $('.jd_win').show();
                    /*that = $(this);*/
                    $('.cancle').on('click',function(){
                        $('.jd_win').hide();
                    })
                alert(re.msg);
              }else{

                   WeixinJSBridge.invoke("getBrandWCPayRequest",re,function(res){
                                WeixinJSBridge.log(res.err_msg);
                                if(res.err_msg=="get_brand_wcpay_request:ok"){

                                    setTimeout("location.href='?r=plugin/users/default/paid'",2);
                                    // ?m=plugin&p=wap&cn=myself&id=food:sit:paid

                                }else{
                                    if(res.err_msg == "get_brand_wcpay_request:cancel"){
                                      var err_msg = "您取消了支付";
                                    }else if(res.err_msg == "get_brand_wcpay_request:fail"){
                                      var err_msg = "支付失败<br/>错误信息："+res.err_desc;
                                    }else{
                                      var err_msg = res.err_msg +"<br/>"+res.err_desc;
                                    }
                                    alert(err_msg);
                                }
                            });

                }
            },'json');
        });
    });
    function toUtf8(str) {
    var out, i, len, c;
    out = "";
    len = str.length;
    for(i = 0; i < len; i++) {
        c = str.charCodeAt(i);
        if ((c >= 0x0001) && (c <= 0x007F)) {
            out += str.charAt(i);
        } else if (c > 0x07FF) {
            out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
            out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
        } else {
            out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));
            out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));
        }
    }
    return out;
}
</script>

<script type="text/javascript">

  $(function(){
       $('#aliPay').click(function(){
             var address="<?php echo $return1['id']?>";
             var not_shop="<?php echo $_SESSION['not_shop'];?>";
             var eid="<?php echo isset($eid)?$eid:0?>"
            if(address=='' && not_shop && eid=='')
            {
                alert('你还没有添加收货地址，请添加');
                window.location.href='?r=plugin/users/default/add_address';
                return false;
            }
            var a1=$.trim($("#remark").val());
            var order_id="<?php echo $data2['id']?>";
            var postData={remark:a1};
            postData.order_id=order_id;
            postData.address="<?php echo $return1['province']?><?php echo $return1['city']?><?php echo $return1['town']?><?php echo $return1['detail']?>";
            postData.address_user="<?php echo $return1['consignee']?>";
            postData.paytype = 'alipay';
            postData.address_tel="<?php echo $return1['phone']?>";
            console.log(postData);
            // return false;
            $.post('?r=plugin/users/default/confirmpay',postData,function(re){
               console.log(re);
          if(re.error == 2){
                /*var that;*/
                $("#qr-code-autopay").empty();
                var str = toUtf8(re.msg);
              $("#qr-code-autopay").qrcode({
          //render: "table",
          text: re.msg
        });
                  $('.jd_win').show();
                  /*that = $(this);*/
                    $('.cancle').on('click',function(){
                        $('.jd_win').hide();
                    })
                //alert(re.msg);
              }
            },'json');
        });

  });
</script>
