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
                                    <a class="btn btn-warning" href="?r=plugin/shops/index/do_shop_table">
                                        返回餐桌管理
                                    </a>
                                </div>
                            </div>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                                <input type="hidden" name="storeid" value="2" />
                                <input type="hidden" name="id" value="" />
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        桌台 详情
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                                                名字(桌台号)
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="title" class="form-control" value="" placeholder=""
                                                />
                                                <span class="help-block">
                                                    例如：C001
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                                                可供就餐人数
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="number" name="user_count" class="form-control" value="" placeholder=""
                                                />
                                                <span class="help-block">
                                                    设置为自动排号时，当排号客户的用餐人数少于等于此人数时，系统将自动为排号客户分配此队列
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                                                桌台类型
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" style="margin-right:15px;" id="tablezonesid"
                                                autocomplete="off" class="form-control">
                                                    <?php foreach ($datas as $key=>
                                                        $v) {?>
                                                        <option value="<?php echo $v['id'];?>">
                                                            <?php echo $v[ 'title'];?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                                <div class="help-block">
                                                    还没有分类，点我
                                                    <a href="?r=plugin/shops/index/do_shop_table_type_add">
                                                        <i class="fa fa-plus-circle">
                                                        </i>
                                                        添加分类
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                                                标签
                                            </label>
                                            <div class="col-sm-9">
                                                <select class="form-control" style="margin-right:15px;" id="table_label_id"
                                                autocomplete="off" class="form-control">
                                                    <option value="0" selected="selected">
                                                        无
                                                    </option>
                                                    <?php foreach ($printlabel as $key=>
                                                        $value) {?>
                                                        <option value="<?php echo $value['id'] ?>">
                                                            <?php echo $value[ 'title']?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                                <div class="help-block">
                                                    还没有标签，点我
                                                    <a href="?r=plugin/shops/index/do_shop_table_printlabel_add">
                                                        <i class="fa fa-plus-circle">
                                                        </i>
                                                        添加标签
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">
                                                排序
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="number" name="displayorder" class="form-control" value=""
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12" style="margin-top: 20px;">
                                        <a href="javascript:;" id="add" class="btn btn-primary col-lg-3">
                                            提交
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <script type="text/javascript">
            $(function() {
                $('#add').click(function() {
                    var title = $("input[name='title']").val();
                    var user_count = $("input[name='user_count']").val();
                    var tablezonesid = $("#tablezonesid").val();
                    var table_label_id = $("#table_label_id").val();
                    var displayorder = $('input[name="displayorder"]').val();
                    if (title.length < 4) {
                        swal("友情提示！", '名字(桌台号)格式不对', "error");
                        return false;
                    }
                    if (!/^[0-9]*$/.test(user_count)) {
                        swal("友情提示！", '可供就餐人数格式不对', "error");
                        return false;
                    }
                    if (user_count.length < 1) {
                        swal("友情提示！", '可供就餐人数格式不对', "error");
                        return false;
                    }
                    var data = {}
                    data.title = title;
                    data.user_count = user_count;
                    data.tablezonesid = tablezonesid;
                    data.table_label_id = table_label_id;
                    data.displayorder = displayorder;
                    data._csrf = '<?= Yii::$app->request->csrfToken ?>';

                    $.post('?r=plugin/shops/index/do_shop_table_add', data,
                    function(re) {
                        console.log(re);
                        if (re.error == 0) {
                            swal({
                                title: "友情提示！",
                                text: re.msg,
                                type: "success"
                            },
                            function() {
                                window.location.href="?r=plugin/shops/index/do_shop_table";
                            });
                        } else {
                            swal("友情提示！", re.msg, "error")
                        }

                    },
                    'json');
                });

            });
        </script>
        </body>

        </html>