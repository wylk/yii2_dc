<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>附近商家列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link href="<?php echo FOOD_PATH?>wap/css/mui.min.css" type="text/css"  rel="stylesheet" />
    <link href="<?php echo FOOD_PATH?>wap/css/app.css" type="text/css"  rel="stylesheet" />

</head>
<body>
    <div id="list"></div>
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/2.0.0/jquery.min.js"></script>
<script src="<?php echo FOOD_PATH?>wap/js/mui.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<!-- <script src="https://lepay.51ao.com/pay_cashier_static/js/share.js"></script> -->
<script>
   wx.config({
          debug: false,
           appId: '<?php echo $wxinfo["appId"];?>',
           timestamp: <?php echo $wxinfo["timestamp"];?>,
           nonceStr: '<?php echo $wxinfo["nonceStr"];?>',
           signature: '<?php echo $wxinfo["signature"];?>',
          jsApiList : [ 'checkJsApi','openLocation','getLocation' ]
      });
        wx.ready(function(){
            wx.checkJsApi({
                jsApiList: [
                    'getLocation'
                ],
                success: function (res) {
                    // alert(JSON.stringify(res));
                    // alert(JSON.stringify(res.checkResult.getLocation));
                    if (res.checkResult.getLocation == false) {
                        alert('你的微信版本太低，不支持微信JS接口，请升级到最新的微信版本！');
                        return;
                    }
                }
            });
             wx.getLocation({
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度
                    // alert(latitude);
                    //ajax请求服务器
                    var postData={lat:latitude};
                    postData.lng=longitude;
                    console.log(postData);
                    $.post('index.php?r=plugin/users/default/shop_list',postData,function(re){
                      if(re.error==0)
                      {
                          $(re.msg).each(function(index,el){
                                  $("#list").append('<div class="mui-content"><div class="mui-card"><ul class="mui-table-view"><li class="mui-table-view-cell"><a href="index.php?r=plugin/users/default/choose_table&shop_id='+el.id+'"><span class="mui-badge mui-badge-success" style="top: 25%;">'+el.distance/1000+'km</span>店铺：'+el.shop_name+'<br /><span class="mui-ellipsis-2">地址：'+el.shop_address+'</span></a></li></ul></div></div>');
                                });
                      }else
                      {
                          console.log(re.msg);
                      }
                    },'json');
                },
                cancel: function (res) {
                    alert('用户拒绝授权获取地理位置');
                }
            });


        });

</script>