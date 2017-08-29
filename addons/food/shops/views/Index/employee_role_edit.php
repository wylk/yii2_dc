<style type="text/css">

 .sortable{
     text-align: center;
 }

  .ul1{
   list-style:none;
  }
  .ul1 li {
     border: 1px solid #dae3e9;
     width:70%;
     float: left;
     min-height:40px;
    line-height: 40px
  }
  </style>

	<!-- main container -->
   <div class="content">
        
        <!-- settings changer -->  
        <div id="pad-wrapper" class="users-list">
            <div class="row header">
                <h3>修改角色</h3>
            </div>

            <!-- Users table -->
            <div class="row" style="border:1px solid #dae3e9; min-height: 500px" >
                <div class="col-md-12">
                   <div class="col-md-12 field-box" style="margin-top:30px">
                                <label>角色名</label>
                                <input type="hidden" value="<?php echo $roles['id'];?>"  id='hidd'></input>
                                <input class="form-control" type="text" / style="width: 46%" id="role_name" value="<?php echo $roles['role_name']?>">
                    </div>
                   <p style="clear:both;"></p>
                    <div  style="border:1px solid #dae3e9; min-height: 500px; margin: 19px 19px;padding-top:20px">
                    <ul class="ul1">
                        <?php foreach ($auth1 as $k => $value) {?>
                        <li  <?php if(($k+2) == 2){ echo 'style="width:20%;text-align: center;font-size: 16px;min-height:162px"';}else{echo 'style="width:20%;text-align: center;font-size: 16px;"';}?>>
                               <input name="auth_id[]" type="checkbox" value="<?php echo $value['id'];?>" <?php if(strpos('a,'.$roles['role_auth_ids'],$value['id'])){ echo 'checked="checked"';}?> id='pid' class="id<?php echo  $value['id'];?>"/><?php echo $value['auth_name'];?>
                            </li>
                        
                           <!--  <li style="width:20%;text-align: center;font-size: 16px;">
                              <input name="auth_id[]" type="checkbox" value="<?php echo $value['id'];?>" <?php if(strpos('a,'.$roles['role_auth_ids'],$value['id'])){ echo 'checked="checked"';}?> id='pid' class="id<?php echo  $value['id'];?>"/><?php echo $value['auth_name'];?>
                           </li> -->
                             
                            <li>
                                <?php foreach ($auth2 as $v) {?> 
                                    <?php if($value['id'] == $v['auth_pid']){?> 
                                        <span style="margin-left: 30px"><input name="auth_id[]" type="checkbox" value="<?php echo $v['id'];?>" onClick="find_fid(<?php echo $value['id'];?>)" id='id<?php echo $value['id'];?>' <?php if(strpos($roles['role_auth_ids'],$v['id'])){ echo 'checked="checked"';}?>/><?php echo $v['auth_name']?></span>
                                    <?php }?>
                                <?php }?> 
                            </li>
                             <?php if(($k+1)%2==0){ echo '</ul><ul class="ul1" style="clear:both">';}?>
                        
                         <?php }?>
                    </ul>
                    <div style="clear:both "><a href="javascript:;"   class="btn btn-default" style="margin-top:20px;margin-right: 90px;float: right;" id="add">修改</a></div>
                    </div>
                </div>                
            </div>
            
            <!-- end users table -->
        </div>
    </div>
 
</body>
</html>

<script type="text/javascript">
    $(function(){
      var i = 1;
      $('[id=pid]').click(function(){
           var id = $(this).val();
           if($(this).is(":checked")){
             $('[id = id'+id+']').prop('checked', true);
           }else{
             $('[id = id'+id+']').prop('checked', false);
           }
            
      });

       $('#add').click(function(){
           var a1='';
        $('input[name="auth_id[]"]:checked').each(function(){
            a1+=$(this).val()+",";
        });
        if(a1=='')
        {
            alert('至少选择一项');
            return false;
        }
        var role_name = $('#role_name').val();
        if (role_name.length<1) {
            alert('角色名不能太短，请从新添加');return false;
        }
        var data= {}
        data.role_name = role_name;
        data.all_id = a1;
        data.role_id = $('#hidd').val();
        data._csrf = '<?= Yii::$app->request->csrfToken ?>';
        $.post('?r=plugin/shops/index/do_employee_role_edit',data,function(re){
            console.log(re);
               if (re.error == 0) {
                    alert(re.msg);
                    window.location.href='?r=plugin/shops/index/do_employee_role';
               }else{
                    alert(re.msg);
               }
           },'json');
       });
       
    });
    function find_fid(id){
          $('.id'+id).prop('checked', true); 
       }
</script>