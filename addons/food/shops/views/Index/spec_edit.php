    <div class="content">
        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>修改商品规格</h3>
                </div>
            </div>
            <form method="post">
            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                    <input class="form-control" type="hidden" name="cid"  value="<?php echo $data1['id']?>" />
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <!-- <form class="new_user_form"> -->
                            <div class="col-md-12 field-box">
                                <label>规格名称:</label>
                                <input class="form-control" type="text" name="spec_name" placeholder="规格名称" value="<?php echo $data1['spec_name']?>" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>状态:</label>
                                <?php if($data1['status']==1):?>
                                <label>
                                <input type="radio" name="status" id="optionsRadios1" value="1" checked>开启
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0">关闭
                                  </label>
                              <?php else:?>
                                <label>
                                <input type="radio" name="status" id="optionsRadios1" value="1" >开启
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0" checked>关闭
                                  </label>
                                <?php endif;?>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>规格排序:</label>
                                <input class="form-control" type="text" name="sort" placeholder="数字越大越靠前" value="<?php echo $data1['sort']?>"/>
                            </div>

                           <h4>添加属性</h4>
                           <br>

                            <div id="aa">
                            <?php
                            foreach(json_decode($data1['spec_value'],true) as $v):
                            ?>
                            <div class="form-inline">
                                <label>添加属性:</label>
                              <div class="form-group">
                                <label class="sr-only" for="exampleInputEmail3"></label>
                                <input type="text" class="form-control" id="exampleInputEmail3" placeholder="属性名称" name="spec_value[]" value="<?php echo $v['spec_name'];?>">
                              </div>
                              <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword3"></label>
                                <input type="text" class="form-control" id="exampleInputPassword3" placeholder="比例" name="proportion[]" value="<?php echo $v['proportion']?>">
                              </div>
                              <a href="javascript:;" onclick="$(this).parent().remove()">删除</a>

                              </div>
                              <br>
                          <?php endforeach;?>


                            </div>

                               <a href="#" id="b1">点我添加属性</a>

                            <div class="col-md-11 field-box actions">
                                <input type="submit" class="btn-glow primary" value="确定修改">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>
                        </form>
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
    <script>
        $(function(){
            $('[id=b1]').click(function(){
                $("#aa").append('<div class="form-inline" id="b3"><label>添加属性:</label><div class="form-group"><label class="sr-only" for="exampleInputEmail3"></label><input type="text" class="form-control" id="exampleInputEmail3" placeholder="属性名称" name="spec_value[]"></div><div class="form-group"><label class="sr-only" for="exampleInputPassword3"></label><input type="text" class="form-control" id="exampleInputPassword3" placeholder="比例" name="proportion[]"></div><a href="javascript:;" onclick="$(this).parent().remove()">删除</a></div><br>');
            });

        });
    </script>

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
            var a1=$("input[name='spec_name']").val();
            var a2=$("input[name='sort']").val();
            var a3=$("input:radio:checked").val();
            var a4=$("input[name='spec_value']").val();
            var a6=$("input[name='proportion']").val();

            if(a1=='')
            {
                alert('商品规格不能为空');
                return false;
            }
            if(a2=='')
            {
                alert('规格排序不能为空');
                return false;
            }
            if(a4=='')
            {
                alert('属性值不能为空');
                return false;
            }
            if(a6=='')
            {
                alert('比例不能为空');
                return false;
            }
            // var postData={spec_name:a1};
            // postData.sort=a2;
            // postData.status=a3;
            // postData.spec_value=a4;
            // postData.basic_price=a5;
            // postData.proportion=a6;
            // console.log(postData);
            // $.post('?m=plugin&p=shop&cn=index&id=food:sit:cat_add',postData,function(re){
            //     if(re.error==0)
            //     {
            //         alert(re.msg);
            //     }else
            //     {
            //         alert(re.msg);
            //     }
            // },'json');
        });
    });
</script>