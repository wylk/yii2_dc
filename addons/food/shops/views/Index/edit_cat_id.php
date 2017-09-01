
    <div class="content">

        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>请选择菜品分类相应权限</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                            <?php if(!empty($data))
                            {
                                foreach($data as $v):
                            ?>
                            <div class="col-md-12 field-box">
                               <div class="checkbox">
                                  <label>
                                   <?php
                                    if(in_array($v['id'],$cat_auth))
                                    {
                                        $checked='checked="checked"';
                                    }else
                                    {
                                        $checked='';
                                    }
                                  ?>
                                    <input type="checkbox" name="cat_id" value="<?php echo $v['id']?>" <?php echo $checked;?>><?php echo $v['cat_name']?>
                                  </label>
                                </div>
                                </div>
                                <?php endforeach;}else{?>
                                    暂无分类数据
                                <?php };?>


                            <div class="col-md-11 field-box">
                                <input type="submit" class="btn-glow primary" value="确定提交">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
</body>
</html>
<script>
    $(function(){
        $(':submit').click(function(){
            var id_array=new Array();
            $('input[name="cat_id"]:checked').each(function(){
                id_array.push($(this).val());//向数组中添加元素
            });
            var a1=id_array.join(',');//将数组元素连接起来以构建一个字符串
            if(a1=='')
            {
                alert('请至少选择一项');
                return false;
            }
            var postData={cat_id:a1};
            postData.role_id="<?php echo $role_id;?>"
            postData._csrf = '<?= Yii::$app->request->csrfToken ?>';
            console.log(postData);
            $.post('?r=plugin/shops/index/edit_ntrance_cat_id',postData,function(re){
                if(re.error==0)
                {
                    alert(re.msg);
                    setTimeout(function(){
                        window.location.href="?r=plugin/shops/index/do_ntrance";
                    },1000);
                    console.log(re.msg);
                }else
                {
                    alert(re.msg);
                    console.log(re.msg);
                }
            },'json');
        });
    });
</script>