<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <a href="#" onclick="getElementById('uploadform3-imagefile').click()">点击添加图片</a>
    <!--  <input type="file" name="image" style="opacity:0;filter:alpha(opacity=0);" id="inputfile"/> -->
    <?= $form->field($model, 'imageFile')->fileInput()?>
    <button>Submit</button>

<?php ActiveForm::end() ?>
<script src="<?php echo FOOD_PATH?>wap/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(function(){
           $("#uploadform3-imagefile").change(function(){
        //创建FormData对象
        var data = new FormData();
        //为FormData对象添加数据
        //
        $.each($('#uploadform3-imagefile')[0].files, function(i, file) {
            data.append('uploadform3-imagefile', file);
        });
        console.log(data);
        // return false;
         $.ajax({
            url:'?r=plugin/stores/homepage/test',
            type:'POST',
            data:data,
            cache: false,
            contentType: false,    //不可缺
            processData: false,    //不可缺
            success:function(re){
                if(re.error==0)
                {
                    console.log(re.msg);
                }else
                {
                    console.log(re.msg);
                }
                // data = $(data).html();
                // if($("#feedback").children('img').length == 0) $("#feedback").append(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
                // else $("#feedback").children('img').eq(0).before(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
            }
        });
     });
    });
</script>