<style type="text/css">
	.content{
       width:90%;
      margin:0px auto ;
	}
	.contents{
		border:1px solid #f1f1f1;
        width:50%;
       margin:80px auto 0px;
	}	
</style>
<div style="min-height: 600px;clear: both;margin-top: 40px;" >
<div class="contents">
<div class="content">
<div class="container-fluid" style="text-align: center;">
	<div class="row-fluid">
		<div class="span12">
			<h3>
				权限模块修改
			</h3>
		</div>
	</div>
</div>
<form>
  <div class="form-group">
    <label for="exampleInputEmail1">模块名</label>
    <input type="email" class="form-control"  placeholder="模块名" id="auth_name" value="<?php echo $authInfo1['auth_name'];?>">
  </div>
  <div class="form-group">
  <label for="exampleInputEmail1">选择父类</label>
	  <select  class="form-control" id="auth_pid">
		  <option value="0">顶级</option>
		  <?php foreach ($authInfo as $key => $value) {?>
		   <option value="<?php echo $value['id'];?>" <?php if($value['id'] == $authInfo1['auth_pid']){ echo 'selected="selected"';}?>><?php echo $value['auth_name']?></option>
		  <?php }?>
	 </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">控制器</label>
    <input type="email" class="form-control"   id="auth_a" placeholder="控制器" value="<?php echo $authInfo1['auth_a'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">方法</label>
    <input type="email" class="form-control"   id="auth_c" placeholder="方法" value="<?php echo $authInfo1['auth_c'];?>">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">log</label>
    <input type="email" class="form-control"   id="auth_url" placeholder="log" value="<?php echo $authInfo1['auth_url'];?>">
  </div>
  <div class="form-group">
        <label>是否显示</label>&nbsp;
        显示：<input  type="radio" name="status" <?php if($authInfo1['is_show'] == 1){echo 'checked="checked"';}?> value="1"/> &nbsp;&nbsp;不显示：<input  type="radio" name="status" value='0' <?php if($authInfo1['is_show'] == 0){echo 'checked="checked"';}?>/>
    </div>
  <input type="hidden" value="<?php echo $authInfo1['id'];?>" id='hidd'></input>
  <p style="margin-left: 50%"><a href="javascript:;" class="btn btn-default" id="submit">修改</a></p>
 
 </form>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
	
	$(function(){
		$('#submit').click(function(){
               var auth_pid = parseInt($("#auth_pid").val());
               var auth_name= $("#auth_name").val();
               var auth_a= $("#auth_a").val();
               var auth_c = $("#auth_c").val();
               var auth_url = $("#auth_url").val();
               var id = $("#hidd").val();
               if (auth_name.length < 2) {
               	  alert('输入模块名格式不对请重新输入'); return false;
               }
               if (auth_a.length < 2) {
               	  alert('输入控制器格式不对请重新输入'); return false;
               }
                if (auth_c.length < 2) {
               	  alert('输入方法名格式不对请重新输入'); return false;
               }
              var status = $('input:radio[name="status"]:checked').val();
              if (status.length<0) {
                   alert('请选择是否展示'); return false;  
              }
              var adddata = {}
              adddata.auth_name = auth_name;
	            adddata.id = id;
	            adddata.auth_pid = auth_pid;
	            adddata.auth_a = auth_a;
	            adddata.auth_c = auth_c;
	            adddata.auth_url = auth_url;
              adddata.is_show = status;
              adddata._csrf = "<?= Yii::$app->request->csrfToken?>";
  	         $.post('/?r=admin/company/menu_edit',adddata,function(re){
  	               	if (re.error == 0) {
                          alert(re.msg);
                          window.location.href='?r=admin/company/shop_menu'
  	               	}else{
                          alert(re.msg);
                          //window.location.href='/index.php?m=admin&c=app&a=module&mod=food&type=doroleLidt'
  	               	}

  	            },'json');
             
		});
	}); 
</script>
