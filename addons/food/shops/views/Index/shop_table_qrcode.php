
  <style type="text/css">

 .sortable{
     text-align: center;
 }
  </style>

    <!-- main container -->
   <div class="content">

        <!-- settings changer -->
        <div id="pad-wrapper" class="users-list">

            <!-- Users table -->
            <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
    <div class="panel-body">
        <div class="header">
            <h3>
                桌台 列表
            </h3>
        </div>
        <div class="form-group">
            <a class="btn btn-success btn-sm" href="?r=plugin/shops/index/do_shop_table">
                <i class="fa fa-circle-o">
                </i>
                桌台状态
            </a>
            <a class="btn btn-success btn-sm"  href="?r=plugin/shops/index/do_shop_table_qrcode">
                <i class="fa fa-qrcode">
                </i>
                二维码
            </a>
            <a class="btn btn-primary btn-sm" href="?r=plugin/shops/index/do_shop_table_add">
                新建 桌台
            </a>
            <a class="btn btn-warning btn-sm" href="javascript:;"
            onclick="return confirm('确认操作吗？');return false;" id="allsataus">
                一键清台
            </a>
            <div class="form-group inline-form" style="display: inline-block;margin-bottom: 0px;">
                <form accept-charset="UTF-8" action="./index.php" class="form-inline"
                id="diandanbao/table_search" method="get" role="form">
                    <div style="margin:0;padding:0;display:inline">
                        <input name="utf8" type="hidden" value="✓">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="q_name">
                            名字(桌台号)
                        </label>
                        <input class="form-control" id="keyword" name="keyword" placeholder="名字(桌台号)"
                        type="search">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="q_table_zone_id_eq">
                            Table zone 等于
                        </label>
                        <select id="tablezonesid" name="tablezonesid" class="form-control-excel">
                            <option value="">
                                桌台类型
                            </option>
                            <option value="1">
                                大厅
                            </option>
                            <option value="2">
                                包厢
                            </option>
                            <option value="3">
                                包厢
                            </option>
                        </select>
                    </div>
                    <input class="btn btn-sm btn-success" name="commit" type="submit" value="搜索">
                    <!--<a class="btn btn-success btn-sm" data-remote="true" href="">批量导出桌子二维码供打印(横版)</a>-->
                    <!--<a class="btn btn-primary btn-sm" data-remote="true" href="">批量导出桌子二维码供打印(竖版)</a>-->
                </form>
            </div>
        </div>
        <style type="text/css">
            .state-table{
                float: left;
                height: 250px;
                width: 180px;
                margin-right:2%;
            }
            .state{
                border:1px solid #dddddd;
                height: 170px;
                width: 100%;
                text-align: center;
                line-height: 80px;
                color: white;
                font-size: 16px;

            }

            .table_title{

            }
            .overflow-ellipsis{
                background-color: #eeeeee;
                text-align: center;
                padding-top: 8px;

            }

            #qr-code-autopay{
                /* border: 1px dashed #dddddd; */
                width: 90%;
                height:90%;
                margin: 5% 5%;

            }
            img{
                width: 100%;
                height:100%;
            }

        </style>
        <div id="queue-setting-index-body">
            <div class="table-state-tables">
                <div class="col-xs-12">
            <!--  餐桌 -->
            <?php foreach ($datas as $key => $v) {  ?>


                    <div class="state-table" data-id="<?php echo $v['id']?>">
                        <a class="idle round" href="?r=plugin/shops/index/do_shop_table_info&table_id=<?php echo $v['id'];?>"
                        data-remote="" title="点击查看订单详情">
                            <div class="state" id="state<?php echo $v['status']?>">
                                <div id="qr-code-autopay">
                                   <img src="<?php echo $v['url']?>"/>
                                </div>
                            </div>
                        </a>

                        <div class="name overflow-ellipsis">
                        <a download href="<?php echo $v['url']?>" target="_blank" ><span class="glyphicon glyphicon-download-alt" style="float: left;margin-left:6px; " ></span></a>
                            <span>
                                <a href="">
                                    <?php echo $v['title']?>
                                </a>
                            </span>
                           <a href="javascript:;" id="del" data-id="<?php echo $v['id'];?>"> <span class='glyphicon glyphicon-trash'
                             style="float:right;margin-right: 6px;"></span></a>
                        </div>
                        <div style="color:green;font-size:12px;text-align:center" class="table_title">
                            标签：<?php echo $v['c_title']?>
                        </div>
                        <div style="font-size:12px;text-align:center" class="table_title">
                            餐桌类型：<?php echo $v['b_title']?>
                        </div>
                    </div>

                <?php } ?>
                    <!-- 餐桌end -->

                </div>
                <div class="col-xs-4">
                    <div class="table-order">
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="clearfix">
            </div>
        </div>
    </div>
</div>

            </div>
            <!-- end users table -->
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function(){
        var _csrf = '<?= Yii::$app->request->csrfToken ?>';
        $('[id=del]').click(function(){
           var id = $(this).data('id');
            if (confirm('你确定要删除吗')) {
                $.get('?r=plugin/shops/index/shop_table_del',{id:id,_csrf:_csrf},function(re){
                    console.log(re);
                    if (re.error == 0) {
                        swal({
                            title: "友情提示！",
                            text: re.msg,
                            type: "success"
                            },
                            function() {
                                window.location.reload();
                            });
                    }else{
                        alert(re.msg);
                   }
                },'json');
            }

       });

       $('#allsataus').click(function(){
        console.log('ok');
        
            $.get('?r=plugin/shops/index/table_allstatus',{ids:'all',_csrf:_csrf},function(re){
              if (re.error == 0) {
                swal({
                    title: "友情提示！",
                    text: re.msg,
                    type: "success"
                    },
                    function() {
                        window.location.reload();
                    });
              }else{
                alert(re.msg);
              }
            },'json');
       });
    });

    function   SaveAs5(imgURL)
    {
      var   oPop   =   window.open(imgURL,"","width=1,   height=1,   top=5000,   left=5000");
      for(;   oPop.document.readyState   !=   "complete";   )
      {
        if   (oPop.document.readyState   ==   "complete")break;
      }
      oPop.document.execCommand("SaveAs");
      oPop.close();
    }
</script>