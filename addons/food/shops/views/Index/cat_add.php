
    <div class="content">

        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>商品分类</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                        <!-- <form class="new_user_form"> -->
                            <div class="col-md-12 field-box">
                                <label>分类名称:</label>
                                <input class="form-control" type="text" name="cat_name"/>
                            </div>

                            <div class="col-md-12 field-box">
                                <label>所属分类:</label>
                                <div class="ui-select span5">
                                    <select name="pid" id="se">
                                    <option value="0">顶级分类</option>
                                    <?php if(!empty($data)){
                                        foreach($data as $v):
                                        ?>

                                        <option value="<?php echo $v['id']?>"><?php echo $v['cat_name']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>分类状态:</label>
                                <label>
                                <input type="radio" name="status" id="optionsRadios1" value="1" checked>开启
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0">关闭
                                  </label>

                            </div>

                            <div class="col-md-12 field-box textarea">
                                <label>分类描述:</label>
                                <textarea class="col-md-9" name="cat_desc" id="aa"></textarea>
                                <span class="charactersleft">分类描述不少于2个字</span>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>排序:</label>
                                <input class="col-md-9 form-control" name="sort" type="text" placeholder="数字越大越靠前" />

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
            var a1=$("input[name='cat_name']").val();
            var a2=$("#se").val();
            var a3=$("input:radio:checked").val();
            // alert(a4);
            // return false;
            var a4=$("#aa").val();
            var a5=$("input[name='sort']").val();
            var _csrf = '<?= Yii::$app->request->csrfToken ?>';
            if(a1=='')
            {
                alert('分类名称不能为空');
                return false;
            }
            if(a4=='')
            {
                alert('分类描述不能为空');
                return false;
            }
            if(a5=='')
            {
                alert('分类排序不能为空');
                return false;
            }
            var postData={cat_name:a1};
            postData.pid=a2;
            postData.status=a3;
            postData.cat_desc=a4;
            postData.sort=a5;
            postData._csrf=_csrf;
            console.log(postData);

            $.post('?r=plugin/shops/index/do_cat_add',postData,function(re){
                if(re.error==0)
                {

                    alert(re.msg);
                    setTimeout(function(){
                        window.location.href="?r=plugin/shops/index/do_goods_cat";
                    },1000);
                }else
                {
                    alert(re.msg);
                }
            },'json');
        });
    });
</script>