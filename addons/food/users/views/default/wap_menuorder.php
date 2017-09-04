
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo FOOD_PATH;?>wap/css/menuorderstyle.css" type="text/css"rel="stylesheet" />
    <title>菜谱点餐</title>
</head>
<a href="?r=plugin/users/default/cart_index&shop_id=<?php echo $mid;?>" class="amount">
      已点<span class="share">0</span><div id="total"></div>
</a>
<body>
<header>
    <a href="#" class="return"><img src="<?php echo FOOD_PATH;?>img/return.png" /></a>
    <p class="switch">
    <a href="?r=plugin/users/default/wap_ordermeal&shop_id=<?php echo $mid; ?>&table_id=<?php echo $table_id; ?>">快速点餐</a>
    <a href="?r=plugin/users/default/wap_menuorder&shop_id=<?php echo $mid; ?>&table_id=<?php echo $table_id; ?>" class="selected">菜谱点餐</a></p>
</header>


<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="<?php echo FOOD_PATH;?>wap/images/wapad.webp"></div>
    </div>
</div>

<div class="nav-lf">
    <ul class="classes" id="nav">
        <?php if(!empty($data)){
        $i=0;
          foreach($data as $v):

          $v['default']='';
          if($v['default']==1)
            {$class="class='current'";}else{$class='';}
          $i += 1;
        ?>
               <li <?php echo $class;?>><a href="#st<?php echo $i;?>"><?php echo $v['cat_name']?></a><b>1</b></li>
            <?php endforeach;}else{?> 暂无数据 <?php };?>
    </ul>
</div>
<div id="container" class="container">
<?php if(!empty($data)){
    $ii=0;
    foreach($data as $kk => $vv){

      $ii += 1;
    ?>

    <div class="section" id="st<?php echo $ii;?>">
    <?php foreach ($data1 as $key => $v1) {
     if($vv['id'] == $v1['cat_id']){?>
        <div class="prt-lt">
          <div class="lt-lt"><img src="<?php echo $v1['goods_img']?>"/>
              <i <?php if($v1['is_recommend'] == 1) { echo 'class="commend"'; } else { echo 'class=" "';} ?>></i>
<!--               <i <?php if($v1['is_recommend'] == 1) { echo 'class="commend"'; } else { echo 'class=" "';} ?>></i> -->
          </div>
          <div class="lt-ct">
            <p><?php echo $v1['goods_name']?></p>
            <p class="pr">¥<span class="price"><?php echo $v1['goods_price'];?></span></p>
          </div>
       <!--    <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken;?>" /> -->
        <div class="lt-rt">
          <input type="button" class="minusindex"value="-" data-id="<?php echo $v1['id']?>" price="<?php echo $v1['goods_price']?>">
          <input type="text" class="result" value="0">
          <input type="button" class="add" value="+" data-id="<?php echo $v1['id']?>" price="<?php echo $v1['goods_price']?>">
        </div>
        </div>
      <?php } } ?>
    </div>
    <?php }}else{?>
      暂无数据
    <?php };?>
</div>
<div class="footer-space"></div>
<footer>
<ul>
<li><a href="?r=plugin/users/default/choose_table&shop_id=<?php echo $mid;?>">
<img src="<?php echo FOOD_PATH?>img/footer_01.png" /><p>台 况</p></a></li>

<li><a href="?r=plugin/users/default/wap_bill&shop_id=<?php echo $mid;?>">
<img src="<?php echo FOOD_PATH?>img/footer_02.png" /><p>账 单</p></a></li>

<li><a href="?r=plugin/users/default/wap_callout&shop_id=<?php echo $mid;?>">
<img src="<?php echo FOOD_PATH?>img/footer_03.png" /><p>呼 叫</p></a></li>

<li><a href="?r=plugin/users/default/wap_more&shop_id=<?php echo $mid;?>">
<img src="<?php echo FOOD_PATH?>img/footer_04.png" /><p>更 多</p></a></li>
</ul>
</footer>
</body>
</html>

<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/Adaptive.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/swiper.min.js"></script>

<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/jquery.nav.js"></script>
<script type="text/javascript">

$(function(){
    $('#nav').onePageNav();
});

</script>
<script>
$(function(){

    $(".add").click(function(){
    var t=$(this).parent().find('input[class*=result]');
    t.val(parseInt(t.val())+1);
    // var t1 = $(this).parent().find('input[class*=result]');
    var num1=t.val();
    setTotal();
    var goods_id=$(this).data('id');
    // console.log(goods_id);
    // return false;
    var goods_price=$(this).attr('price');
    // console.log(goods_price);
    // return false;
    var shop_id="<?php echo $mid?>";
    var table_id="<?php echo $table_id;?>"
    var _csrf="<?php echo \Yii::$app->request->csrfToken?>";
    var postData={goods_id:goods_id};
    postData.goods_price=goods_price;
    postData.num=num1;
    postData.csrf=_csrf;
    postData.shop_id=shop_id;
    // postData.table_id=table_id;
    console.log(postData);
   $.get('?r=plugin/users/default/cart',postData,function(re){
            if(re.error==0)
            {
                console.log(re.msg);
                // window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
            }else
            {
                console.log(re.msg);
            }
        },'json');
    })

    $(".minusindex").click(function(){
    var t=$(this).parent().find('input[class*=result]');
    t.val(parseInt(t.val())-1);
    var num1=t.val();
    if(parseInt(t.val())<0){
    t.val(0);
    }
    setTotal();
    var goods_id=$(this).data('id');
    // console.log(goods_id);
    // return false;
    var goods_price=$(this).attr('price');
    var shop_id="<?php echo $mid?>";
    var table_id="<?php echo $table_id;?>"
    var _csrf="<?php echo \Yii::$app->request->csrfToken?>";
    var postData={goods_id:goods_id};
    postData.goods_price=goods_price;
    postData.num=num1;
    postData.csrf=_csrf;
    postData.shop_id=shop_id;
    console.log(postData);
    // return false;
   $.get('?r=plugin/users/default/cart',postData,function(re){
            if(re.error==0)
            {
                console.log(re.msg);
                // window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
            }else
            {
                console.log(re.msg);
            }
        },'json');
    })

    function setTotal(){
    var s=0;
    var v=0;
    var n=0;
    <!--计算总额-->
      $(".lt-rt").each(function(){
      s+=parseInt($(this).find('input[class*=result]').val())*parseFloat($(this).siblings().find('span[class*=price]').text());
    });
    <!--计算菜种-->
    var nIn = $("li.current a").attr("href");
    $(nIn+" input[type='text']").each(function() {
    if($(this).val()!=0){
    n++;
    }
    });

    <!--计算总份数-->
    $("input[type='text']").each(function(){
        v += parseInt($(this).val());
    });
    if(n>0){
        $(".current b").html(n).show();
    }else{
        $(".current b").hide();
    }
        $(".share").html(v);
        $("#total").html(s.toFixed(2));
    }
    setTotal();
})
</script>


<script>
$('.add').bind('click',function(){
    var img = $(this).parent().parent().find('img');
    var flyElm = img.clone().css('opacity', 0.75);
    $('body').append(flyElm);
    flyElm.css({
        'z-index': 9000,
        'display': 'block',
        'position': 'absolute',
        'top': img.offset().top +'px',
        'left': img.offset().left +'px',
        'width': img.width() +'px',
        'height': img.height() +'px'
        });
    flyElm.animate({
        top: $('.share').offset().top,
        left: $('.share').offset().left,
        width: 20,
        height: 20
        }, 700, function() {
        flyElm.remove();
    });
});
</script>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo FOOD_PATH?>wap/js/navbar2.js"></script>