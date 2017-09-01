
    <div class="content">
        <!-- settings changer -->
        <div id="pad-wrapper" class="new-user">
            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar" style="border-right: 1px solid #fff;padding-left: 85px">
                    <div class="container">
                        <div class="main">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a class="btn btn-warning" href="/?r=plugin/shops/index/do_shop_queue">
                                        返回排队管理
                                    </a>
                                </div>
                            </div>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                                <input type="hidden" name="storeid" value="2" />
                                <input type="hidden" name="id" value="" />
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        队列设置 详情  <a href="javascript:;" id="del" data-id="<?php echo $data['id'];?>"> <span class='glyphicon glyphicon-trash'
                             style="float:right;margin-right: 6px;"></span></a>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">队列名称</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title" class="form-control" value="<?php echo $data['title']?>"  placeholder="例如：1-2桌"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">客人数量少于等于多少人排入此队列</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="limit_num" class="form-control" value="<?php echo $data['limit_num']?>" placeholder="例如：2"/>
                                                <span class="help-block">
                                                    设置为自动排号时，当排号客户的用餐人数少于等于此人数时，系统将自动为排号客户分配此队列
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">营业时间</label>
                                            <div class="col-sm-4">
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" value="<?php echo $data['starttime']?>" name="starttime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group clockpicker">
                                                    <input type="text" class="form-control" value="<?php echo $data['endtime']?>" name="endtime" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">队列编号前缀</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="prefixs" class="form-control" value="<?php echo $data['prefixs']?>"  placeholder="例如：C-"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">提前通知人数</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="notify_number" class="form-control" value="<?php echo $data['notify_number']?>" placeholder=""/>
                                                <span class="help-block">
                                                    队列有状态变更时, 提前通知的人数
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
                                            <div class="col-sm-9">
                                                <label for="isshow1" class="radio-inline"><input type="radio" name="status" value="1" id="isshow1"  <?php if($data['status'] == 1){echo 'checked="true"';}?> /> 是</label>
                                                &nbsp;&nbsp;&nbsp;
                                                <label for="isshow2" class="radio-inline"><input type="radio" name="status" value="0" id="isshow2"   <?php if($data['status'] == 0){echo 'checked="true"';}?>/> 否</label>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="displayorder" class="form-control" value="<?php echo $data['displayorder'];?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                <a href="javascript:;" class="btn btn-primary col-lg-2" id="add" data-id="<?php echo $data['id']?>">提交</a>
                                    
                                    
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end main container -->
        <!-- scripts -->
        <script type="text/javascript" src="<?php echo FOOD_PATH;?>js/My97DatePicker/WdatePicker.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#add').click(function() {
                    var edit_id = $(this).data('id');
                    var title = $("input[name='title']").val();
                    var limit_num = $("input[name='limit_num']").val();
                    var starttime = $("input[name='starttime']").val();
                    var endtime = $("input[name='endtime']").val();
                    var prefixs = $("input[name='prefixs']").val();
                    var notify_number = $("input[name='notify_number']").val();
                    var status = $('input[name="status"]:checked').val();
                    var displayorder = $('input[name="displayorder"]').val();
                    if (title.length < 2) {
                        swal("友情提示！", '列队名称格式不对', "error");
                        return false;
                    }
                    if (!/^[0-9]*$/.test(limit_num)) {
                        swal("友情提示！", '客人数量格式不对', "error");
                        return false;
                    }
                    if (limit_num.length < 1) {
                        swal("友情提示！", '客人数量格式不对', "error");
                        return false;
                    }
                    if (endtime.length < 7 || starttime.length < 7) {
                        swal('友情提示','营业时间不能为空','error');
                        return false;
                    }

                    if (prefixs.length < 1) {
                         swal('友情提示','队列编号格式不对','error');
                         return false;
                    }
                    var data = {}
                    data.title = title;
                    data.limit_num = limit_num;
                    data.starttime = starttime;
                    data.endtime = endtime;
                    data.prefixs = prefixs;
                    data.notify_number = notify_number;
                    data.status = status;
                    data.displayorder = displayorder;
                    data.edit_id = edit_id;
                    data._csrf = '<?= Yii::$app->request->csrfToken ?>';
                    $.post('?r=plugin/shops/index/do_shop_queue_edit', data,
                    function(re) {
                        console.log(re);
                        if (re.error == 0) {
                            swal({
                                title: "友情提示！",
                                text: re.msg,
                                type: "success"
                            },
                            function() {
                             window.location.href = '?r=plugin/shops/index/do_shop_queue'
                            });
                        } else {
                            swal("友情提示！", re.msg, "error")
                        }

                    },'json');
                });

                $('#del').click(function(){
                    var del_id = $(this).data('id');
                    var data  = {}
                    data.del_id = del_id;
                    data._csrf = '<?= Yii::$app->request->csrfToken ?>';
                    $.get('?r=plugin/shops/index/shop_queue_del',data,function(re){
                        console.log(re);
                        if (re.error == 0) {
                            swal({
                                title: "友情提示！",
                                text: re.msg,
                                type: "success"
                            },
                            function() {
                             window.location.href = '?r=plugin/shops/index/do_shop_queue'
                            });  
                        }else{
                            swal("友情提示！", re.msg, "error")
                        }

                    },'json');
                })

            });
        </script>
        </body>

        </html>