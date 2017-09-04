/*点餐首页需用JS开始*/

$(function () {
	//加的效果
	$(".add").click(function () {
		$(this).prevAll().css("display", "inline-block");
		var n = $(this).prev().text();
		var num = parseInt(n) + 1;
		if (num == 0) { return; }
		$(this).prev().text(num);

		var danjia = $(this).next().text();//获取单价

		// console.log(danjia);
		var a = $("#totalpriceshow").html();//获取当前所选总价

		$("#totalpriceshow").html((a * 1 + danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量

		var c=$("#totalcountshow").html(nm*1+1);
		var gid=$(this).data('id');
		// alert(gid);
    var shop_id=$(this).attr('sid');
    alert(shop_id);
    return false;
    // alert(shop_id);
    console.log(shop_id);
    // return false;
    // var csrf="<?php echo \Yii::$app->request->csrfToken;?>";
		var postData={goods_id:gid};
		postData.goods_price=danjia;
		postData.num=num;
    postData.shop_id=shop_id;
    // postData.csrf=csrf;
		console.log(postData);
		// return false;
		$.get("?r=plugin/users/defualt/cart",postData,function(re){
			if(re.error==0)
			{
				console.log(re.msg);
				// window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
			}else
			{
				console.log(re.msg);
			}
		},'json');
		jss();//<span style='font-family: Arial, Helvetica, sans-serif;'></span>   改变按钮样式
	});

	//减的效果
	$(".minusindex").click(function () {
		var n = $(this).next().text();
		var num = parseInt(n) - 1;

		$(this).next().text(num);//减1

		var danjia = $(this).nextAll(".price").text();//获取单价
		var a = $("#totalpriceshow").html();//获取当前所选总价
		$("#totalpriceshow").html((a * 1 - danjia * 1).toFixed(2));//计算当前所选总价

		var nm = $("#totalcountshow").html();//获取数量
		$("#totalcountshow").html(nm * 1 - 1);
		//如果数量小于或等于0则隐藏减号和数量
		if (num <= 0) {
			$(this).next().css("display", "none");
			$(this).css("display", "none");
			jss();//改变按钮样式
			 return
		}
		var gid=$(this).data('id');
    var shop_id=$(this).attr('sid');
		var postData={goods_id:gid};
		postData.goods_price=danjia;
		postData.num=num;
    postData.shop_id=shop_id;
		console.log(postData);
		$.get('?r=plugin/users/defualt/cart',postData,function(re){
			if(re.error==0)
			{
				console.log(re.msg);
				// window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:cart&table_id=1&shop_id=7';
			}else
			{
				console.log(re.msg);
			}
		},'json');

	});
	function jss() {
		var m = $("#totalcountshow").html();
		if (m > 0) {
			$(".right").find("a").removeClass("disable");
		} else {
		   $(".right").find("a").addClass("disable");
		}
	};
	//选项卡
	$(".con>div").hide();
	$(".con>div:eq(0)").show();

	$(".left-menu li").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		var n = $(".left-menu li").index(this);
		$(".left-menu li").index(this);
		$(".con>div").hide();
		$(".con>div:eq("+n+")").show();
	});
});
/*点餐首页需用JS结束*/


/*菜单隐藏JS代码开始*/
$(document).ready(function(){
    function anim(duration){
        $('#mint').animate(
            {height: 'toggle'},
            {duration: duration}
        );
    }
    $('#closebtn').click(function() {
        $('#mintbar').slideUp();

        anim(600);
        $('.box-bj').css(
        {
        	"z-index":"10",
        	"filter":"alpha(Opacity=55)",
        	"-moz-opacity":"0.55",
        	"opacity":"0.55"
        })
       /*$("p").css({"font-size":"8px","background-color":"#8888888"});
        $(".box-bj").css('z-index','10');*/
    });

    $('#mint').click(function() {
        anim(600);
        $('#mintbar').slideDown('slow');
        $(".box-bj").css(
          {
            "z-index":"-10",
            "filter":"alpha(Opacity=100)",
            "-moz-opacity":"1",
            "opacity":"1"
 })
    });

});
/*菜单隐藏JS代码结束*/


/*购物车JS代码开始*/
   var that;
    $('.delete_box').on('click',function(){
    $(this).children('.delete_up').css(
    {
        transition :'all 1s',
        'transformOrigin':"0 5px" ,
        transform :'rotate(-30deg) translateY(2px)'
    }
    )
    $('.jd_win').show();
    that = $(this);
})
    $('.cancle').on('click',function(){
        $('.jd_win').hide();
        $('.delete_up').css('transform','none')
    })
    $('.submit').on('click',function(){
       var gid=that.parents('.shop-arithmetic').find("a").data('id');
       var postData={goods_id:gid};
       postData.carf=csrf;
       console.log(postData);
       // return false;
       $.get('?r=plugin/users/default/delete_cart',postData,function(re){
        if(re.error==0)
        {
            alert(re.msg);
            window.location.reload();
        }else
        {
            alert(re.msg);
        }
       },'json');
        // console.log();
        // return false;
        // // return false;
        // // var id=$(this).data('id');
        // // alert(id);
        // // return false;
        // that.parents(".shop-info").remove();

        $('.jd_win').hide();
        if($(".shop-info").length == 0) {
            $("#AllTotal").text(allprice.toFixed(2));
        }
    })

    function hidden_del() {//隐藏删除按钮
        $('.delete_box').show();$('.edit').hide();$('.finish').show();
    }
    function finish_edit() {//显示删除按钮
        $('.delete_box').hide();$('.edit').show();$('.finish').hide();
    }

  $(function(){

  // 数量减
  $(".minus").click(function() {
    var t = $(this).parent().find('.num');
        var n = $(this).next().text();
        var num = parseInt(n) - 1;
        // console.log(num);
        if(num<=0)
        {
            alert('商品数量至少有1个');
            return false;
        }
    t.text(parseInt(t.text()) - 1);
    if (t.text() <= 1) {
      t.text(1);
    }
    TotalPrice();
        var goods_id=$(this).data('id');
        // console.log(goods_id);
        var goods_price=$(this).attr('price');
        // console.log(goods_price);
        var postData={goods_id:goods_id};
        postData.goods_price=goods_price;
        postData.num=num;
        postData.csrf=csrf;
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
  });
  // 数量加
  $(".plus").click(function() {
    var t = $(this).parent().find('.num');
        var num1=t.text();
        var n = $(this).prev().text();
        var num = parseInt(num1) + 1;

    t.text(parseInt(t.text()) + 1);
    if (t.text() <= 1) {
      t.text(1);
    }
    TotalPrice();
        var goods_id=$(this).data('id');
        // console.log(goods_id);
        var goods_price=$(this).attr('price');
        // console.log(goods_price);

        var postData={goods_id:goods_id};
        postData.goods_price=goods_price;
        postData.num=num;
        postData.csrf=csrf;
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

  });
    /********************结算*************************/
     $('.settlement').click(function(){
            if(confirm('是否确定提交订单？')==false)
            {
                return false;
            }
            var all=$('#AllTotal').text();
            var n=$("#allnum").text();
            if(all==0.00 && n==0)
            {
                alert('请至少选择一个商品付款');
                return false;
             // var dom=$(this);
            }
            var AllTotal=$('#AllTotal').text();
            var allnum=$('#allnum').text();
            // console.log(allnum);
            // return false;
            var ids ='';
            $('input[name="goodsCheck"]:checked').each(function(){
                ids+=$(this).val()+',';
            });
            var data = {}
                data.cat_id = ids;
                data.total=AllTotal;
                data.goods_num=allnum;
                data.csrf=csrf;
                console.log(data);
                // return false;
            $.get('?r=plugin/users/default/add_order_goods',data,function(re){
                if(re.error==0)
                {
                    console.log(re.msg);
                    // alert(re.msg);
                  window.location.href='?r=plugin/users/default/confirmpay&order_id='+re.msg;
                }else
                {
                    console.log(re.msg);
                }

            },'json')

         /*   $(".shop-group-item").each(function() { //循环每个店铺
              var oprice = 0; //店铺总价
              var AllNum=0;
              $(this).find(".goodsCheck").each(function() { //循环店铺里面的商品
                if ($(this).is(":checked")) { //如果该商品被选中
                  var num = parseInt($(this).parents(".shop-info").find(".num").text()); //得到商品的数量
                  var goods_id=parseInt($(this).parents(".shop-info").find(".goods_id").text());

                  var price = parseFloat($(this).parents(".shop-info").find(".price").text()); //得到商品的单价
                  var total = price * num; //计算单个商品的总价
                  oprice += total; //计算该店铺的总价
                  AllNum+=num;
                  var postData={goods_id:goods_id};
                  postData.goods_num=num;
                  postData.total=total;
                    console.log(postData);
                  // return false;
                  $.post('?m=plugin&p=wap&cn=index&id=food:sit:add_order_goods',postData,function(re){
                    if(re.error==0)
                    {
                        console.log(re.msg);
                    }else
                    {
                        console.log(re.msg);
                    }
                  },'json');
                }
                $(this).closest(".shop-group-item").find(".ShopTotal").text(oprice.toFixed(2));
                $(this).closest(".shop-group-item").find(".Shopnum").text(AllNum); //显示被选中商品的店铺总价
                // console.log(AllNum);
              });
              // console.log(num);
              //     return false;
              var oneprice = parseFloat($(this).find(".ShopTotal").text()); //得到每个店铺的总价
              allprice += oneprice; //计算所有店铺的总价
              var allnumber=parseFloat($(this).find(".Shopnum").text());
              allnumber1+=allnumber;
              // console.log(allnumber1);
            });

            $("#AllTotal").text(allprice.toFixed(2)); //输出全部总价
            $("#allnum").text(allnumber1);

            // console.log(n);
            // console.log(all);
            // return false;
            var postData={total:all};
            postData.goods_num=n;
            console.log(postData);
            $.post('?m=plugin&p=wap&cn=index&id=food:sit:add_order',postData,function(re){
                if(re.error==0)
                {
                    console.log(re.msg);
                    window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:confirmPay&order_id='+re.msg;
                }else
                {
                    console.log(re.msg);
                   // window.location.href='?m=plugin&p=wap&cn=index&id=food:sit:confirmPay&order_id='+re.msg;
                }
            },'json');*/
        });
  /******------------分割线-----------------******/
    // 点击商品按钮
  $(".goodsCheck").click(function() {
    var goods = $(this).closest(".shop-group-item").find(".goodsCheck"); //获取本店铺的所有商品
    var goodsC = $(this).closest(".shop-group-item").find(".goodsCheck:checked"); //获取本店铺所有被选中的商品
    // console.log(goodsC);

    var Shops = $(this).closest(".shop-group-item").find(".shopCheck"); //获取本店铺的全选按钮
    if (goods.length == goodsC.length) { //如果选中的商品等于所有商品
      Shops.prop('checked', true); //店铺全选按钮被选中
      if ($(".shopCheck").length == $(".shopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
        $("#AllCheck").prop('checked', true); //全选按钮被选中
        TotalPrice();
      } else {
        $("#AllCheck").prop('checked', false); //else全选按钮不被选中
        TotalPrice();
      }
    } else { //如果选中的商品不等于所有商品
      Shops.prop('checked', false); //店铺全选按钮不被选中
      $("#AllCheck").prop('checked', false); //全选按钮也不被选中
      // 计算
      TotalPrice();
      // 计算
    }
  });
  // 点击店铺按钮
  $(".shopCheck").click(function() {
    if ($(this).prop("checked") == true) { //如果店铺按钮被选中
      $(this).parents(".shop-group-item").find(".goods-check").prop('checked', true); //店铺内的所有商品按钮也被选中
      if ($(".shopCheck").length == $(".shopCheck:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
        $("#AllCheck").prop('checked', true); //全选按钮被选中
        TotalPrice();
      } else {
        $("#AllCheck").prop('checked', false); //else全选按钮不被选中
        TotalPrice();
      }
    } else { //如果店铺按钮不被选中
      $(this).parents(".shop-group-item").find(".goods-check").prop('checked', false); //店铺内的所有商品也不被全选
      $("#AllCheck").prop('checked', false); //全选按钮也不被选中
      TotalPrice();
    }
  });
  // 点击全选按钮
  $("#AllCheck").click(function() {
    if ($(this).prop("checked") == true) { //如果全选按钮被选中
      $(".goods-check").prop('checked', true); //所有按钮都被选中
      TotalPrice();
    } else {
      $(".goods-check").prop('checked', false); //else所有按钮不全选
      TotalPrice();
    }
    $(".shopCheck").change(); //执行店铺全选的操作
  });
  //计算
  function TotalPrice() {
    var allprice = 0; //总价
    var allnumber1=0;
    $(".shop-group-item").each(function() { //循环每个店铺
      var oprice = 0; //店铺总价
      var AllNum=0;
      $(this).find(".goodsCheck").each(function() { //循环店铺里面的商品
        if ($(this).is(":checked")) { //如果该商品被选中
          var num = parseInt($(this).parents(".shop-info").find(".num").text()); //得到商品的数量
          var price = parseFloat($(this).parents(".shop-info").find(".price").text()); //得到商品的单价
          var total = price * num; //计算单个商品的总价
          oprice += total; //计算该店铺的总价
          AllNum+=num;
        }
        $(this).closest(".shop-group-item").find(".ShopTotal").text(oprice.toFixed(2)); //显示被选中商品的店铺总价
        $(this).closest(".shop-group-item").find(".Shopnum").text(AllNum);
      });
      var oneprice = parseFloat($(this).find(".ShopTotal").text()); //得到每个店铺的总价
      allprice += oneprice; //计算所有店铺的总价
      var allnumber=parseFloat($(this).find(".Shopnum").text());
        allnumber1+=allnumber;
    });

    $("#AllTotal").text(allprice.toFixed(2)); //输出全部总价
    $("#allnum").text(allnumber1);
  }
});
/*购物车JS代码结束语*/

/*删除地址JS代码开始*/
var athat;
    $('.addr_del').on('click',function(){
    $('.ajd_win').show();
    athat = $(this);
})
    $('.acancle').on('click',function(){
        $('.ajd_win').hide();

    })
    $('.asubmit').on('click',function(){
        var aid=athat.parent().find("span").text();
        var postdata={aid:aid};
        console.log(postdata);
        $.post('?r=plugin/users/default/del_address',postdata,function(re){
            if(re.error==0)
            {
                alert(re.msg);
                window.location.href="?m=plugin&p=wap&cn=myself&id=food:sit:address_list";
            }else
            {
                alert(re.msg);
            }
        },'json');
        // return false;
        // that.parents().parents(".address").remove();
        $('.ajd_win').hide();
        if($(".address").length == 0) {
        }
    })
    function del_art() {
        alert("你确定要删除该地址吗？")
}


/*检查地址输入情况*/
/*function chenkObj() {

    var name = document.getElementById('name').value;
    var phone = document.getElementById('phone').value;
    var detailed = document.getElementById('detailed').value;
    var province=$('#province').val();
    var city=$('#city').val();
    var town=$('#town').val();
    // var detail=$("input[name='detail']").val();
    if(name == ""){
        alert("请输入收货人姓名！");
        return false;
    }
    if(phone == ""){
        alert("请输入收货人电话！");
        return false;
    }else{
        if(!(/^1[34578]\d{9}$/.test(phone))){
            alert("手机号码有误，请重填");
            return false;
        }
    }
    if(detailed == ""){
        alert("请输入收货人详细地址！");
        return false;
    }
    var postData={consignee:name};
    postData.phone=phone;
    postData.province=province;
    postData.city=city;
    postData.town=town;
    postData.detail=detailed;
    console.log(postData);
    $.post('?m=plugin&p=wap&cn=index&id=food:sit:add_address',postData,function(re){
        if(re.error==0)
        {
            alert(re.msg);
            window.location.href="?m=plugin&p=wap&cn=index&id=food:sit:address_list";
        }else
        {
            alert(re.msg);
        }
    },'json');
}*/

/*删除地址JS代码结束*/
/*添加编辑地址JS代码开始*/
function chenkObj() {

    var name = document.getElementById('name').value;
    var phone = document.getElementById('phone').value;
    var detailed = document.getElementById('detailed').value;
    var province=$('#province').val();
    var city=$('#city').val();
    var town=$('#town').val();
    var aid=$("input[name='aid']").val();
    // var aid=$("input[name='aid']").val();
    // var detail=$("input[name='detail']").val();
    if(name == ""){
        alert("请输入收货人姓名！");
        return false;
    }
    if(phone == ""){
        alert("请输入收货人电话！");
        return false;
    }else{
        if(!(/^1[34578]\d{9}$/.test(phone))){
            alert("手机号码有误，请重填");
            return false;
        }
    }
    if(province == "省份"){
      alert("请选择省份");
      return false;
    }else{
      if(city == "地级市"){
        alert("请选择地级市");
        return false;
      }else{
        if(town == "市、县级市、县"){
          alert("请选择市、县级市、县");
          return false;
        }
      }
    }
    if(detailed == ""){
        alert("请输入收货人详细地址！");
        return false;
    }

    var postData={consignee:name};
    postData.phone=phone;
    /*if(postData.province == province && postData.city == city &&  postData.town == town){
      province = postData.province = null;
      city = postData.city = null;
      town = postData.town = null;
    }*/
    postData.province = province;
    postData.city = city;
    postData.town = town
    postData.detail=detailed;
    // postData.aid=aid;
    postData._csrf=csrf;
    postData.id=aid;
   console.log(postData);
var  filename=location.href;
      filename=filename.substr(filename.lastIndexOf('/')+1);
if(filename.indexOf("edit") != -1){
    $.post('?r=plugin/users/default/edit_address',postData,function(re){
        if(re.error==0)
        {
            alert(re.msg);
            window.location.href='?r=plugin/users/default/address_list';
        }else
        {
            alert(re.msg);
            window.location.href='?r=plugin/users/default/address_list';
        }
    },'json');
  }else{

    $.post('?r=plugin/users/default/add_address',postData,function(re){
        if(re.error==0)
        {
            alert(re.msg);
            window.location.href="?r=plugin/users/default/address_list";
        }else
        {
            // alert(re.msg);
            console.log(re.msg);
        }
    },'json');
  }
}
/*编辑地址JS代码结束*/

/*if($(".nodata").text() == "暂无数据"){

  $(".main").css("height","100%");
}else{
  $(".main").css("height","auto");
}*/
  $('.input_province').on('click',function(){

    $('.input_province').hide();$('.input_city').hide();$('.input_town').hide();
    $('#province').show();$('#city').show();$('#town').show();
    window.onload=setup(); preselect('北京市');
  })
  $('.input_city').on('click',function(){
      alert("请先选择省份");
      return false;
  })

  $('.input_town').on('click',function(){
    alert("请先选择省份");
    return false;
  })
/*添加编辑地址JS代码开始*/