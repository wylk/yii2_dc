
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<title>欢迎登陆超管系统</title>
<link rel="stylesheet" type="text/css" href="<?php echo FOOD_PATH;?>public/css/super_login.css">
<link rel="stylesheet" href="<?php echo FOOD_PATH;?>fonts/font-awesome.min.css"/>
<script src="<?php echo FOOD_PATH?>/public/js/jquery.js,jquery.backstretch.min.js" type="text/javascript"></script>
<hao></hao>
</head>
<body>
<?php echo $content;?>
<script type="text/javascript">
$.backstretch([
'<?php echo FOOD_PATH?>public/images/101.jpg',
'<?php echo FOOD_PATH?>public/images/202.jpg',
'<?php echo FOOD_PATH?>public/images/303.jpg',


], {
fade : 1000, // 动画时长
duration : 2000 // 切换延时
});
$(function(){
	var filename=location.href;
		filename=filename.substr(filename.lastIndexOf('/')+1);  
	$('#aa').click(function(){
	console.log(1);
	var a1=$("input[name='phone']").val();
	var a2=$("input[name='password']").val();

	if(a1=='')
		{
			if(filename.indexOf("shop") != -1){
				alert('登录账号不能为空');
				return false;
			}else{
				alert('手机号不能为空');
				return false;
			}
		}
	if(a2=='')
		{
			alert('登录密码不能为空');
			return false;
		}
	var postData = {}
	postData.phone=a1;
	postData.password=a2;
	postData._csrf = '<?= Yii::$app->request->csrfToken ?>';
	if(filename.indexOf("shop") != -1){
		$.post('?r=plugin/publics/default/shop_login',postData,function(re){
		console.log(re);
		if(re.error==0)
			{
				alert(re.msg);
				window.location.href='?r=plugin/shops/index/index';
			}else if(re.error==1)
			{
				alert(re.msg);
			}else if(re.error==2)
			{
				alert(re.msg);
				//window.location.href='?m=plugin&p=public&cn=index&id=food:sit:edit_company&cid='+re.cid;
			}
			},'json');
		}else{

		$.post('?r=plugin/publics/default/super_login',postData,function(re){
				if(re.error==0)
				{
					alert(re.msg);
					window.location.href='?r=plugin/stores/homepage/index';
				}else if(re.error==1)
				{
					alert(re.msg);
				}else if(re.error==2)
				{
					alert(re.msg);
					window.location.href='?r=plugin/publics/default/edit_company&cid='+re.cid;
				}
			},'json');
		}
	});
});
</script>
<end></end>
</body>
</html>