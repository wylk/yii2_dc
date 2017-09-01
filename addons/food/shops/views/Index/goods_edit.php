<?php
use yii\widgets\ActiveForm;
?>
    <div class="content">



        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3>商品修改</h3>
                </div>
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar">
                    <div class="container">
                       <!--  <form method="post" enctype="multipart/form-data"> -->
                       <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']]) ?>
                        <input class="form-control" type="hidden" name="cid" value="<?php echo $data1['id']?>" />
                            <div class="col-md-12 field-box">
                                <label>商品名称:</label>
                                <input class="form-control" type="text" name="goods_name" value="<?php echo $data1['goods_name']?>" />
                            </div>
                             <div class="col-md-12 field-box">
                                <label>商品分类:</label>

                                <div class="ui-select span5">
                                    <select name="cat_id" id="se">
                                    <?php if(!empty($data2)){
                                        foreach($data2 as $v):
                                            if($v['id']==$data1['cat_id'])
                                            {
                                                $selected='selected="selected"';
                                            }else
                                            {
                                                $selected='';
                                            }
                                        ?>

                                        <option value="<?php echo $v['id']?>" <?php echo $selected?>><?php echo $v['cat_name']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>商品规格:</label>

                                <div class="ui-select span5">
                                    <select name="goods_spec" id="se1">
                                    <option value="0">--请选择--</option>
                                    <?php if(!empty($data3)){
                                        foreach($data3 as $v):
                                            if($v['id']==$data1['goods_spec'])
                                            {
                                                $selected='selected="selected"';
                                            }else
                                            {
                                                $selected='';
                                            }
                                        ?>

                                        <option value="<?php echo $v['id']?>" <?php echo $selected;?>><?php echo $v['spec_name']?></option>

                                        <?php endforeach;}else{?>
                                             <option value="0">暂无数据</option>
                                        <?php };?>
                                    </select>
                                </div>
                            </div>
                            <div class='js_uploadBox'>
                                <div class="form-group">
                                 <div class="col-md-12 field-box">
                                    <!-- <label for="goods_img" class='js_uploadText'>商品主图:</label>
                                    <input type="file" id="goods_img" name="goods_img" class="js_upFile"> -->
                                    <?= $form->field($model, 'imageFile')->fileInput()->label('商品主图:') ?>
                                </div>
                                 <div class="js_showBox" ><img class="js_logoBox" src="<?php echo $data1['goods_img']?>" style="width:200px;"></div>
                                </div>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>供应时间:</label>
                                <?php
                                $data4=['星期一','星期二','星期三','星期四','星期五','星期六','星期日'];
                                $data5=explode(',', $data1['suppy_time']);

                                ?>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox1" name="suppy_time[]" value="<?php echo $data4[0]?>" <?php if(in_array($data4[0],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>><?php echo $data4[0]?>

                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox2" name="suppy_time[]" value="<?php echo $data4[1]?>" <?php if(in_array($data4[1],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[1]?>
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox3" name="suppy_time[]" value="<?php echo $data4[2]?>" <?php if(in_array($data4[2],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[2]?>
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox1" name="suppy_time[]" value="<?php echo $data4[3]?>" <?php if(in_array($data4[3],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[3]?>
                                </label>
                                <br><br>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox2" name="suppy_time[]" value="<?php echo $data4[4]?>" <?php if(in_array($data4[4],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[4]?>
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox3" name="suppy_time[]" value="<?php echo $data4[5]?>" <?php if(in_array($data4[5],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[5]?>
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" id="inlineCheckbox3" name="suppy_time[]" value="<?php echo $data4[6]?>" <?php if(in_array($data4[6],$data5))
                                  {
                                    $checked="checked";
                                  }else
                                  {
                                    $checked='';
                                  }

                                  ?> <?php echo $checked;?>> <?php echo $data4[6]?>
                                </label>

                            </div>
                            <div class="col-md-12 field-box">
                                <label>商品价格:</label>
                                <input class="form-control" type="text" name="goods_price" value="<?php echo $data1['goods_price']?>" />
                            </div>
                            <div class="col-md-12 field-box">
                                <label>会员价格:</label>
                                <input class="form-control" type="text" name="goods_member_price" value="<?php echo $data1['goods_member_price']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>商品原价:</label>
                                <input class="form-control" type="text" name="goods_basic_price" value="<?php echo $data1['goods_basic_price']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>每日库存:</label>
                                <input class="form-control" type="text" name="goods_per_stock" value="<?php echo $data1['goods_per_stock']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>今日已售:</label>
                                <input class="form-control" type="text" name="goods_today_sales" value="<?php echo $data1['goods_today_sales']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>总销量:</label>
                                <input class="form-control" type="text" name="goods_sales" value="<?php echo $data1['goods_sales']?>"/>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>商品单位:</label>
                                <input class="form-control" type="text" name="goods_unit" placeholder="例如:份/斤/碗"  value="<?php echo $data1['goods_unit']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <label>商品描述:</label>
                                <textarea class="form-control" rows="3" name="goods_desc" id="aa"><?php echo $data1['goods_desc']?></textarea>
                            </div>
                             <div class="col-md-12 field-box">
                                <label>商品口味:</label>
                                <input class="form-control" type="text" name="goods_taste" placeholder="例如：麻辣/清淡/酸辣" value="<?php echo $data1['goods_taste']?>"/>
                            </div>
                            <div class="col-md-12 field-box">
                                <?php if($data1['is_onsale']==1):?>
                                <label>是否上架:</label>
                                 <label>
                                    <input type="radio" name="is_onsale" id="optionsRadios1" value="1" checked>上架
                                  </label>
                                  <label>
                                    <input type="radio" name="is_onsale" id="optionsRadios1" value="0"
                                    >下架
                                  </label>
                              <?php else:?>
                                     <label>
                                    <input type="radio" name="is_onsale" id="optionsRadios1" value="1" >上架
                                  </label>
                                  <label>
                                    <input type="radio" name="is_onsale" id="optionsRadios1" value="0"
                                     checked>下架
                                  </label>
                              <?php endif;?>
                            </div>
                            <div class="col-md-12 field-box">

                                <label>是否推荐:</label>
                                <?php if($data1['is_recommend']==1):?>
                                 <label>
                                    <input type="radio" name="is_recommend" id="optionsRadios1" value="1" checked>推荐
                                  </label>
                                  <label>
                                    <input type="radio" name="is_recommend" id="optionsRadios1" value="0"
                                    >不推荐
                                </label>
                            <?php else:?>
                                <label>
                                    <input type="radio" name="is_recommend" id="optionsRadios1" value="1" >推荐
                                  </label>
                                  <label>
                                    <input type="radio" name="is_recommend" id="optionsRadios1" value="0" checked>不推荐
                                </label>
                            <?php endif;?>

                            </div>
                             <div class="col-md-12 field-box">
                                <label>排序:</label>
                                <input class="form-control" type="text" name="goods_sort" placeholder="数字越大越靠前" value="<?php echo $data1['goods_sort']?>" />
                            </div>

                            <div class="col-md-11 field-box actions">
                                <input type="submit" class="btn-glow primary" value="确定修改">
                                <span>or</span>
                                <input type="reset" value="取消" class="reset">
                            </div>

                    </div>
                </div>
           <!--  </form> -->
          <?php  ActiveForm::end();?>
            </div>
        </div>
    </div>
    <!-- end main container -->


    <!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo FOOD_PATH?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/theme.js"></script>
    <script src="http://www.gouguoyin.cn/template/default/js/jquery.pin.js"></script>

    <script src="<?php echo FOOD_PATH?>js/jquery.uploadView.js"></script>
</body>
</html>
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
<script>
   $(function(){
    $(':submit').click(function(){
        var a1=$("input[name='goods_name']").val();
        var id_array=new Array();
        $('input[name="suppy_time"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素
        });
        var a2=id_array.join(',');//将数组元素连接起来以构建一个字符串
        var a3=$("input[name='goods_price']").val();
        var a4=$("input[name='goods_member_price']").val();
        var a5=$("input[name='goods_basic_price']").val();
        var a6=$("input[name='goods_per_stock']").val();
        var a7=$("input[name='goods_today_sales']").val();
        var a16=$("input[name='goods_sales']").val();
        var a8=$("input[name='goods_unit']").val();
        var a9=$("#aa").val();
        var a10=$("input[name='goods_taste']").val();
        var a11=$("input:radio:checked").val();
        var a12=$("input[name='goods_sort']").val();
        var a13=$("#se").val();
        var a14=$("#se1").val();
        var a15=$("input[name='goods_img']").val();
        if(a1=='')
        {
            alert('商品名称不能为空');
            return false;
        }
        // if(a15=='')
        // {
        //     alert('商品主图不能为空');
        //     return false;
        // }
        // if(a2=='')
        // {
        //     alert('供应时间至少选择一项');
        //     return false;
        // }
        if(a3=='')
        {
            alert('商品价格不能为空');
            return false;
        }
        if(a3=='')
        {
            alert('商品价格不能为空');
            return false;
        }
        if(a4=='')
        {
            alert('会员价格不能为空');
            return false;
        }
        if(a5=='')
        {
            alert('商品原价不能为空');
            return false;
        }
        if(a6=='')
        {
            alert('每日库存不能为空');
            return false;
        }
        if(a7=='')
        {
            alert('今日已售不能为空');
            return false;
        }
        if(a16=='')
        {
            alert('总销量不能为空');
            return false;
        }
        if(a8=='')
        {
            alert('商品单位不能为空');
            return false;
        }
        if(a9=='')
        {
            alert('商品描述不能为空');
            return false;
        }
        if(a10=='')
        {
            alert('商品口味不能为空');
            return false;
        }
        if(a12=='')
        {
            alert('商品排序不能为空');
            return false;
        }
        // var postData={goods_name:a1};
        // postData.suppy_time=a2;
        // postData.goods_price=a3;

        // postData.goods_member_price=a4;
        // postData.goods_basic_price=a5;
        // postData.goods_per_stock=a6;
        // postData.goods_today_sales=a7;
        // postData.goods_unit=a8;
        // postData.goods_desc=a9;
        // postData.goods_state=a10;
        // postData.is_onsale=a11;
        // postData.sort=a12;
        // postData.cat_id=a13;
        // postData.goods_spec=a14;
        // console.log(postData);
        // $.post('?m=plugin&p=shop&cn=index&id=food:sit:do_goods_add',postData,function(re){
        //     if(re.error==0)
        //     {
        //         alert(re.msg);
        //         // window.location.reload();
        //     }else
        //     {
        //         alert(re.msg);
        //     }
        // },'json');
    });
   });
</script>