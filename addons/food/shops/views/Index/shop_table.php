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
                                聚贤厅
                            </option>
                            <option value="3">
                                聚义厅
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
        		height: 155px;
        		width: 100px;
        		margin-right:2.52%;
        	}
        	.state{
        		
        		height: 80px;
        		width: 80px;
        		border-radius: 50%;
			    text-align: center;
			    line-height: 80px;
			    margin:1px auto;
			    color: white;
			    font-size: 16px;
			    background-color: #000;
        	}
        	#state1{
        		background-color: red;	
        	}
        	#state2{
        		background-color: #428bca;	
        	}
        	#state3{
        		background-color: #5cb85c;	
        	}
	    	.table_title{
	    		
	    	}
	    	.overflow-ellipsis{
	    		background-color: #eeeeee;
	    		text-align: center;
	    		padding-top: 8px;

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
                            <?php if($v['status'] == 1){?>
                                	已开台
                                <?php }else if($v['status'] == 2 ){ ?>
                                 	已下单
                                <?php }else if($v['status'] == 3 ){ ?>
                                	已支付
                                <?php }else{?>
                                	空闲
                                <?php } ?>
                            </div>
                        </a>
                        <div style="color:green;font-size:12px;text-align:center" class="table_title">
                            标签：<?php echo $v['c_title']?>
                        </div>
                        <div class="name overflow-ellipsis">
                            <span>
                                <a href="">
                                    <?php echo $v['title']?>
                                </a>
                            </span>
                            <form accept-charset="UTF-8" action="" data-remote="true" method="post" style="display:inline-block;">
                                <div style="margin:0;padding:0;display:inline">
                                    <input name="_method" type="hidden" value="PUT">
                                </div>
                                <select id="workflow_state" name="workflow_state" data-id="<?php echo $v['id'];?>">
                                    <option value="0" <?php if($v['status'] == 0){echo 'selected="selected"';}?>>
                                    空闲</option>
                                    <option value="1" <?php if($v['status'] == 1){echo 'selected="selected"';}?>>已开台</option>
                                    <option value="2" <?php if($v['status'] == 2){echo 'selected="selected"';}?>>已下单</option>
                                    <option value="3" <?php if($v['status'] == 3){echo 'selected="selected"';}?>>已支付</option>

                                </select>
                            </form>
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
       $('[id=workflow_state]').change(function(){
           var id = $(this).data('id');
           var status = $(this).val();

           if (!status) {
           		 swal("友情提示！", '餐桌状态已经是你选中的不能修改', "error");return false;
           }
           var data = {}
           data.table_id = id;
           data.status = status
           data._csrf = '<?= Yii::$app->request->csrfToken ?>';
           console.log(data);
           $.post('?r=plugin/shops/index/table_status',data,function(re){
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
     
       });

       $('#allsataus').click(function(){
       	console.log('ok');
        var _csrf = '<?= Yii::$app->request->csrfToken ?>';
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
</script>