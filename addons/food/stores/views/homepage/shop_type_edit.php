<?php
use yii\widgets\ActiveForm;
?>
    <!-- main container -->
    <div class="content">


        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>修改门店类型</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                      <!--   <form class="new_user_form" action="?m=plugin&p=admin&cn=index1&id=food:sit:shop_type_edit" id="defaultForm" enctype="multipart/form-data" method="post"> -->
                        <?php $form = ActiveForm::begin([
                        'id' => 'defaultForm',
                        'options' => ['enctype' => 'multipart/form-data','class'=>'new_user_form']]) ?>
                         <input type="hidden" name="_csrf" value="<?php echo \Yii::$app->request->csrfToken;?>">
                        <input type="hidden" name='id' value="<?php echo $data1['id']?>">
                        <div class="form-group">
                            <div class="col-md-12 field-box">
                                <label for="typename">门店类型名称:</label>
                                <input class="form-control" id="typename" type="text" name="typename" value="<?php echo $data1['typename']?>"/>
                            </div>
                            </div>
                            <div class='js_uploadBox'>
                            <div class="form-group">
                             <div class="col-md-12 field-box">
                              <!--   <label for="type_img" class='js_uploadText'>门店类型图标:</label> -->
                                 <?= $form->field($model, 'imageFile')->fileInput(['class' => 'js_upFile', 'multiple' => true,])->label('门店类型图标:') ?>
                           <!--      <input type="file" id="type_img" name="type_img" class="js_upFile" value="<?php echo $data1['type_img']?>"> -->
                            </div>
                             <div class="js_showBox" ><img class="js_logoBox" src="<?php echo $data1['type_img']?>" width="100px" ></div>
                            </div>
                            </div>

                            <div class="col-md-11 field-box actions">
                                <input type="submit" id="validateBtn" class="btn-glow primary" value="确定修改">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset" id="resetBtn">
                            </div>
                        <!-- </form> -->
                    <?php ActiveForm::end() ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end main container -->
    <script src="<?php echo FOOD_PATH?>wap/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/jquery.uploadView.js"></script>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/theme.js"></script>
    <!-- scripts -->



    <script type="text/javascript">

        $(".js_upFile").uploadView({
            uploadBox: '.js_uploadBox',//设置上传框容器
            showBox : '.js_showBox',//设置显示预览图片的容器
            width : 100, //预览图片的宽度，单位px
            height : 100, //预览图片的高度，单位px
            allowType: ["gif", "jpeg", "jpg", "bmp", "png"], //允许上传图片的类型
            maxSize :2, //允许上传图片的最大尺寸，单位M
            success:function(e){
                $(".js_uploadText").text('更改图片');
                alert('图片上传成功');
            }
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
    $(document).ready(function(){
      $('#validateBtn').click(function(){
        var a1=$("input[name='typename']").val();
        var a2=$("input[name='type_img']").val();

        if(a1=='')
        {
            alert('门店类型不能为空');
            return false;
        }

    });
});
</script>