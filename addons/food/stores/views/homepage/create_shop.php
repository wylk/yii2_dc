
    <div class="content">
        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>创建门店</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                        <!-- <form class="new_user_form"> -->
                         <input type="hidden" name="_csrf"  value="<?php echo \Yii::$app->request->csrfToken?>">
                         <div class="col-md-12 field-box">
                                <label>百度定位:</label>
                                <input class="col-md-7 form-control" type="text" name="shop_location" value="<?php if(!empty($data1['lng']))
                                {
                                    echo $data1['lng'].','.$data1['lat'];
                                }else
                                {
                                    echo '';
                                }
                                    ?>" style="line-height:2px;width:60%"/>
                                    <a style="font-size:15px;" href="?r=plugin/stores/homepage/baidu_map">点击精准定位</a>

                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店名称:</label>
                                <input class="form-control" type="text" name="shop_name"/>
                            </div>

                            <div class="col-md-12 field-box">
                                <label>门店类型:</label>
                                <div class="ui-select span5">
                                    <select name="type_id" id="se">
                                    <?php if(!empty($data)){
                                        foreach($data as $v):
                                        ?>

                                        <option value="<?php echo $v['id']?>"><?php echo $v['typename']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店状态:</label>
                                <label>
                                <input type="radio" name="shop_status" id="optionsRadios1" value="1" checked>开启
                                  </label>
                                  <label>
                                    <input type="radio" name="shop_status" id="optionsRadios1" value="0">关闭
                                  </label>

                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店公告:</label>
                                <input class="col-md-9 form-control" name="shop_notice" type="text" />
                            </div>

                            <div class="col-md-12 field-box">
                                <label>人均消费:</label>
                                <input class="col-md-9 form-control" type="text" name="cost_per"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>门店地址:</label>
                                <div class="address-fields">

                                    <input class="form-control" type="text" placeholder="详细地址" name="shop_detail_address" />
                                    <input class="small form-control" type="text" placeholder="省" name="province" />
                                    <input class="small form-control" type="text" placeholder="市" name="city"/>
                                    <input class="small last form-control" type="text" placeholder="区" name="town" />

                                </div>
                            </div>

                            <div class="col-md-12 field-box textarea">
                                <label>门店介绍:</label>
                                <textarea class="col-md-9" name="shop_introduction" id="aa"></textarea>
                                <span class="charactersleft">门店介绍至少10个汉字</span>
                            </div>
                            <div class="col-md-11 field-box actions">
                                <input type="submit" class="btn-glow primary" value="确定创建">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>
                        <!-- </form> -->
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
            var a1=$("input[name='shop_name']").val();
            var a2=$("input[name='shop_notice']").val();
            var a3=$("input[name='cost_per']").val();
            var a4=$("input[name='shop_detail_address']").val();
            // alert(a4);
            // return false;
            var a5=$("input[name='province']").val();
            var a6=$("input[name='city']").val();
            var a7=$("input[name='town']").val();
            var a8=$("#aa").val();
            // alert(a8);
            // return false;
            var a9=$("input:radio:checked").val();
            var a10=$("#se").val();
            var a11=$.trim($("input[name='shop_location']").val());
            if(a11=='')
            {
                alert('请先使用百度地图精准定位');
                window.location.href='?m=plugin&p=admin&cn=index1&id=food:sit:baidu_map';
                return false;
            }
            if(a1=='')
            {
                alert('门店名称不能为空');
                return false;
            }
            if(a2=='')
            {
                alert('门店公告不能为空');
                return false;
            }
            if(a3=='')
            {
                alert('人均消费不能为空');
                return false;
            }
            if(a4=='')
            {
                alert('门店地址不能为空');
                return false;
            }
            if(a5=='' || a6=='' || a7=='')
            {
                alert('省市区不能为空');
                return false;
            }
            if(a8=='')
            {
                alert('门店简介不能为空');
                return false;
            }
            var _csrf = '<?php echo \Yii::$app->request->csrfToken?>';
            var postData={shop_name:a1};
            postData.shop_notice=a2;
            postData.cost_per=a3;
            postData.shop_address=a5+'省'+a6+'市'+a7+'区'+a4;
            postData.shop_introduction=a8;
            postData.shop_status=a9;
            postData.type_id=a10;
            postData.shop_location=a11;
            postData._csrf=_csrf;
            console.log(postData);
            $.post('index.php?r=plugin/stores/homepage/create_shop',postData,function(re){
                if(re.error==0)
                {
                    alert(re.msg);

                    window.location.href='index.php?r=plugin/stores/homepage/stores_manage';
                }else
                {
                    // alert(re.msg);
                    console.log(re.msg);
                }
            },'json');
        });
    });
</script>