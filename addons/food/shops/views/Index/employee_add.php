   <div class="content">
        
        <!-- settings changer -->
        
        
        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3 style="    margin-left: 95px;">添加员工</h3>
                </div>                
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar" style="border-right: 1px solid #fff;padding-left: 85px">
                    <div class="container">
                        <form class="new_user_form">
                            <div class="col-md-12 field-box">
                                <label>真实姓名</label>
                                <input class="form-control" type="text"  id="truename" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>角色选择</label>
                                <div class="ui-select span5">
                                    <select id="role_id">
                                     <?php foreach ($roles as $key => $v) {?>
                                        
                                        <option value="<?php echo $v['id'];?>"><?php echo $v['role_name'];?></option>
                                        
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>登录账号</label>
                                <input class="col-md-9 form-control" type="text"  id="username" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>登录密码</label>
                                <input class="col-md-9 form-control" type="password"  id="password1" style="width:75%;" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>确认密码</label>
                                <input class="col-md-9 form-control" type="password"  id="password2" style="width:75%;"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>手机号</label>
                                <input class="col-md-9 form-control" type="text" id="phone" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>电子邮箱</label>
                                <input class="col-md-9 form-control" type="text" id="email" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>是否开启</label>&nbsp;
                                开启：<input  type="radio" name="status" checked="checked" value="1"/> &nbsp;&nbsp;关闭：<input  type="radio" name="status" value='0'/>
                            </div>
                            
                            <div class="col-md-11 field-box actions" style="text-align: center;">
                                <input type="button" class="btn-glow default" value="提交" id="add" style="width: 13%;">
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <!-- end main container -->


    <!-- scripts -->
    <script type="text/javascript">
        $(function () {
            $('#add').click(function(){
              var truename = $('#truename').val();
              var role_id = $('#role_id').val();
              var username = $('#username').val();
              var password1 = $('#password1').val();
              var password2 = $('#password2').val();
              var phone = $('#phone').val();
              var email = $('#email').val();
              var _csrf = '<?= Yii::$app->request->csrfToken ?>';
              var regex = new RegExp("^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9_]){1,10}$"); 
              
              if (!regex.test(truename) || truename.length<1) {
                    alert('输入的真实姓名格式不对，请重新输入');return false;
              }
              if (truename.length<2) {
                    alert('输入的真实姓名不能少于2个字符，请重新输入');return false;
              } 
              if (username.length < 6) {
                    alert('输入的登录账号不能少于6个字符，请重新输入');return false;
              }
              if (password1 != password2) {
                     alert('输入的密码不一致，请重新输入');return false;  
              }
              if (password1.length < 6) {
                    alert('输入的登录密码不能少于6个字符，请重新输入');return false;
              }
              if (!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(phone))) {
                    alert('输入的手机号格式不对，请重新输入');return false;
              }
              var myreg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
              if (!myreg.test(email)) {
                     alert('输入的邮箱格式不对，请重新输入');return false;
              }
              var status = $('input:radio[name="status"]:checked').val();
              var data = {}
              data.truename = truename;
              data.role_id = role_id;
              data.username = username;
              data.password = password1;
              data.phone = phone;
              data.email = email;
              data.status = status;
              data._csrf = _csrf;
              console.log(data);
             $.post('?r=plugin/shops/index/do_employee_add',data,function(re){
                console.log(re);
                if (re.error == 0) {
                    alert(re.msg);
                    setTimeout(function(){
                      window.location.href='?r=plugin/shops/index/do_employee_list'

                    },2000);
                }else{
                    alert(re.msg);
                }

             },'json');
            });
           
        });
    </script>
</body>
</html>