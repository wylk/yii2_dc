
    <div class="content">
        
        <!-- settings changer -->
        
        
        <div id="pad-wrapper" class="new-user">
            <div class="row header">
                <div class="col-md-12">
                    <h3 style="    margin-left: 95px;">新建餐桌类型</h3>
                </div>                
            </div>

            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar" style="border-right: 1px solid #fff;padding-left: 85px">
                    <div class="container">
                       <div class="main">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn btn-info" href="?m=plugin&p=shop&cn=index&id=food:sit:do_shop_table_type">返回餐桌类型管理
            </a>
        </div>
    </div>
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="storeid" value="2" />
        <input type="hidden" name="id" value="" />
        <div class="panel panel-default">
            <div class="panel-heading">
                桌台类型 详情
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">名字</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="<?php echo $datas['title']?>"  placeholder="例如：大厅，包厢"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务费比例</label>
                    <div class="col-sm-9">
                        <input type="number" name="service_rate" class="form-control" value="<?php echo $datas['service_rate']?>" placeholder=""/>
                        <span class="help-block">
                            下单时需要支付的百分比 %，随订单的总金额自动调整
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最低消费</label>
                    <div class="col-sm-9">
                        <input name="limit_price" class="form-control" placeholder="" step="any" type="number" value="<?php echo $datas['limit_price']?>"/>
                        <span class="help-block">
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">预订预付款</label>
                    <div class="col-sm-9">
                        <input type="number" name="reservation_price" class="form-control" value="<?php echo $datas['reservation_price']?>" placeholder=""/>
                        <span class="help-block" style="color:#f00;">
                            仅预订订座时需要预付款的金额
                        </span>
                        <input type="hidden" name="hidd" value="<?php echo $datas['id'];?>">
                    </div>
                </div>
                <!--<div class="form-group">-->
                    <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">可预订桌台数量</label>-->
                    <!--<div class="col-sm-9">-->
                        <!--<input type="number" step="1" name="table_count" class="form-control" value=""  placeholder=""/>-->
                    <!--</div>-->
                <!--</div>-->
            </div>
        </div>
        <div class="form-group col-sm-12">
        <a href="javascript:;" id="add" class="btn btn-primary col-lg-3">保存</a>
            <input type="hidden" name="token" value="be1bf441" />
        </div>
    </form>
</div>

                    </div>
                </div>  
            </div>
        </div>
    </div>
  
    <script type="text/javascript">
        $(function () {
            $('#add').click(function(){
              var title = $("input[name='title']").val();
              var type_id = $("input[name='hidd']").val();
              var service_rate = $('input[name="service_rate"]').val();
              var limit_price = $('input[name="limit_price"]').val();
              var reservation_price = $('input[name="reservation_price"]').val();
              
              var data = {}
              data.title = title;
              data.type_id = type_id;
              data.service_rate = service_rate;
              data.limit_price = limit_price;
              data.reservation_price = reservation_price;
              data._csrf = '<?= Yii::$app->request->csrfToken ?>';
             $.post('?r=plugin/shops/index/do_shop_table_type_edit',data,function(re){
                console.log(re);
                if (re.error == 0) {
                    swal({
                     title: "友情提示！",
                         text: re.msg,
                         type: "success"
                     }, function () {
                            window.location.href='?r=plugin/shops/index/do_shop_table_type'
                         });
                }else{
                   swal("友情提示！", re.msg,"error")
                }

             },'json');
            });
           
        });
    </script>
</body>
</html>