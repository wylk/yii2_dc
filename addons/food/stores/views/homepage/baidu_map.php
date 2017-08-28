<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
body,html {
width: 100%;
height: 100%;
margin: 0;
font-family: "微软雅黑";
font-family: "微软雅黑";
}
#allmap {
width: 100%;
height: 500px;
}
p {
margin-left: 5px;
font-size: 14px;
}
</style>
<script type="text/javascript"
    src="http://api.map.baidu.com/api?v=2.0&ak=M1zcN5Nps0TADha7rbPrn45YIlxikdkW"></script>
<title>门店精准定位</title>
</head>
<body>
<div id="allmap"></div>
<p>拖动标志物，获取门店具体位置经纬度</p>
<button id='aa' style="margin-left:500px;">确定</button>
</body>
</html>
<script src="https://cdn.bootcss.com/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript">

// 百度地图API功能
var map = new BMap.Map("allmap");
var point = new BMap.Point(116.404, 39.915);
map.enableScrollWheelZoom();   //启用滚轮放大缩小，默认禁用
map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
map.centerAndZoom(point, 11);
map.addEventListener("click", function(e){
// alert('当前经度:'+e.point.lng+' , 纬度: '+e.point.lat);
var now_point =  new BMap.Point(e.point.lng, e.point.lat );
marker.setPosition(now_point);//设置覆盖物位置
});
var marker = new BMap.Marker(point); //创建marker对象
marker.enableDragging(); //marker可拖拽
//拖拽结束事件
marker.addEventListener("dragend", function(e){
//获取覆盖物位置
var o_Point_now =  marker.getPosition();
var lng = o_Point_now.lng;
var lat = o_Point_now.lat;
//e.point.lng 地理经度。
// e.point.lat 地理纬度。
//alert(e.point.lng + "---, " + e.point.lat);
get_lng_lat();
})
map.addOverlay(marker); //在地图中添加marker
// get_lng_lat();
$('#aa').click(function(){
    get_lng_lat();
    var o_Point_now =  marker.getPosition();
    var lng = o_Point_now.lng;
    var lat = o_Point_now.lat;
    var type="<?php echo isset($_GET['type'])? $_GET['type']: '';?>";
    var bid="<?php echo  isset($_GET['bid'])? $_GET['bid']:'';?>";
    if(type=='1')
    {
        window.location.href='index.php?r=plugin/stores/homepage/shop_edit&bid='+bid+'&lng='+lng+'&lat='+lat;
    }else
    {
        window.location.href='index.php?r=plugin/stores/homepage/create_shop&lng='+lng+'&lat='+lat;
    }
});
//获取经纬度
function get_lng_lat()
{
    //返回覆盖物标注的地理坐标。
    var o_Point_now =  marker.getPosition();
    var lng = o_Point_now.lng;
    var lat = o_Point_now.lat;
    alert('经度:'+lng+' , 纬度: '+lat);
}


        //window.location.href='?m=plugin&p=admin&cn=index1&id=food:sit:create_shop&lng='+lng+'&lat='+lat;



</script>