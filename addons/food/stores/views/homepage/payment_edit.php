
    <div class="content">



        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>修改支付配置</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken?>">
                <input type="hidden" name="pid" value="<?php echo $data1['id']?>">
                <div class="col-md-9 with-sidebar">
                    <div class="container">

                            <div class="col-md-12 field-box">
                                <label>appid:</label>
                                <input class="form-control" type="text" name="appid" placeholder="appid" value="<?php echo $data1['appid']?>"/>
                            </div>
                           <!--   <div class="form-group">
                                <label for="exampleInputEmail1">登录账号:</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Email">
                              </div> -->

                            <div class="col-md-12 field-box">
                                <label>支付秘钥:</label>
                                <input class="form-control" type="text" name="appsecret" placeholder="appsecret" value="<?php echo $data1['appsecret']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>支付商户号:</label>
                                <input class="form-control" type="text" name="mch_id" placeholder="输入支付的商户号mch_id" value="<?php echo $data1['mch_id']?>"/>
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
        var a1=$("input[name='appid']").val();
        var a2=$("input[name='appsecret']").val();
        var a3=$("input[name='mch_id']").val();
        var pid=$("input[name='pid']").val();
        var a4="<?php echo \Yii::$app->request->csrfToken;?>";
        if(a1=='')
        {
            alert('支付appid不能为空');
            return false;
        }
        if(a2=='')
        {
            alert('支付秘钥不能为空');
            return false;
        }
        if(a3=='')
        {
            alert('支付商户号不能为空');
            return false;
        }

        var postData={appid:a1};
        postData.appsecret=a2;
        postData.mch_id=a3;
        postData.id=pid;
        postData._csrf=a4;
        console.log(postData);
        $.post('index.php?r=plugin/stores/homepage/payment_edit',postData,function(re){
            if(re.error==0)
            {
                alert(re.msg);
                window.location.href="index.php?r=plugin/stores/homepage/payment";
            }else
            {
                // alert(re.msg);
                console.log(re.msg);
            }
        },'json');
    });
   });
</script>