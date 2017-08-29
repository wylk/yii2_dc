 <div class="content">



        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>修改店长账号</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                            <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken;?>">
                            <div class="col-md-12 field-box">
                                <label>登录账号:</label>
                                <input class="form-control" type="text" name="username" value="<?php echo $data1['username']?>" />
                            </div>
                           <!--   <div class="form-group">
                                <label for="exampleInputEmail1">登录账号:</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email">
                              </div> -->

                            <div class="col-md-12 field-box">
                                <label>登录密码:</label>
                                <input class="form-control" type="password" name="password" style="width: 75%;" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>确认密码:</label>
                                <input class="form-control" type="password" name="repass" style="width: 75%;"/>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>所属门店:</label>

                                <div class="ui-select span5">
                                    <select name="shop_id" id="se">
                                    <?php if(!empty($data2)){
                                        foreach($data2 as $v):
                                        if($v['id']==$data1['shop_id'])
                                        {
                                            $selected='selected="selected"';
                                        }else
                                        {
                                            $selected='';
                                        }
                                        ?>

                                        <option value="<?php echo $v['id']?>" <?php echo $selected;?>><?php echo $v['shop_name']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>

                              <input class="form-control" type="hidden" name="id" value="<?php echo $data1['id']?>"/>

                             <div class="col-md-12 field-box">
                                <label>真实姓名:</label>
                                <input class="form-control" type="text" name="truename" value="<?php echo $data1['truename']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>手机号码:</label>
                                <input class="form-control" type="text" name="phone" value="<?php echo $data1['phone']?>"/>
                            </div>

                            <div class="col-md-12 field-box">
                                <label>电子邮箱:</label>
                                <input class="form-control" type="text" name="email" value="<?php echo $data1['email']?>"/>
                            </div>

                            <div class="col-md-12 field-box">
                                <label>状态:</label>
                                <?php if($data1['status']==1):?>
                                 <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="1" checked>启用
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0"
                                    >禁用
                                  </label>
                                <?php else:?>
                                    <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="1" >启用
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0"
                                     checked>禁用
                                  </label>
                              <?php endif;?>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>备注:</label>
                                <textarea class="form-control" rows="3" name="remark" id="aa"><?php echo $data1['remark']?></textarea>
                            </div>

                            <div class="col-md-11 field-box actions">
                                <input type="submit" class="btn-glow primary" value="确定修改">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end main container -->


    <!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/theme.js"></script>

    <script type="text/javascript">
        $(function () {

            // toggle form between inline and normal inputs
            var $buttons = $(".toggle-inputs button");
            var $form = $("form.new_user_form");

            $buttons.click(function () {
                var mode = $(this).data("input");
                $buttons.removeClass("active");
                $(this).addClass("active");

                if (mode === "inline") {
                    $form.addClass("inline-input");
                } else {
                    $form.removeClass("inline-input");
                }
            });
        });
    </script>
</body>
</html>
<script>
   $(function(){
    $(':submit').click(function(){
        var a1=$("input[name='username']").val();
        var a2=$("input[name='password']").val();
        var a3=$("input[name='repass']").val();
        var a4=$('#se').val();
        var a5=$("input[name='truename']").val();
        var a6=$("input[name='phone']").val();
        var a7=$("input[name='email']").val();
        var a8=$("input:radio:checked").val();
        var a9=$("#aa").val();
        var a10=$("input[name='id']").val();
        var a11="<?php echo \Yii::$app->request->csrfToken;?>";
        // alert(a10);
        // return false;
        if(a1=='')
        {
            alert('登录账号不能为空');
            return false;
        }
        if(a2=='')
        {
            alert('登录密码不能为空');
            return false;
        }
        if(a3=='')
        {
            alert('确认密码不能为空');
            return false;
        }
        if(a2!=a3)
        {
            alert('两次密码输入不一致');
            return false;
        }
        if(a5=='')
        {
            alert('真实姓名不能为空');
            return false;
        }
        if(a6=='')
        {
            alert('手机号码不能为空');
            return false;
        }
        if(a7=='')
        {
            alert('电子邮箱不能为空');
            return false;
        }
        if(a9=='')
        {
            alert('备注不能为空');
            return false;
        }
        var postData={username:a1};
        postData.password=a2;
        postData.role_id=0;

        postData.shop_id=a4;
        postData.truename=a5;
        postData.phone=a6;
        postData.email=a7;
        postData.status=a8;
        postData.remark=a9;
        postData.id=a10;
        postData._csrf=a11;
        console.log(postData);
        $.post('index.php?r=plugin/stores/homepage/employee_edit',postData,function(re){
            if(re.error==0)
            {
                alert(re.msg);
                window.location.href='index.php?r=plugin/stores/homepage/shopkeeper';
            }else
            {
                alert(re.msg);
                console.log(re.msg);
            }
        },'json');
    });
   });
</script>