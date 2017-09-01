
  <style type="text/css">

 .sortable{
     text-align: center;
 }
  </style>

	<!-- main container -->
   <div class="content">
        
        <!-- settings changer -->  
        <div id="pad-wrapper" class="users-list">
            <div class="row header">
                <h3>餐桌类型</h3>
                <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
                   <!-- <input type="text" class="col-md-5 search" placeholder="输入姓名查询">
                    
                     custom popup filter -->
                    <!-- styles are located in css/elements.css -->
                    <!-- script that enables this dropdown is located in js/theme.js -->
                    <a href="?r=plugin/shops/index/do_shop_table_type_add" class="btn btn-info pull-right">
                        <span>&#43;</span>
                       新建餐桌类型
                    </a>
                </div>
            </div>

            <!-- Users table -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" style="text-align: center">
                        <thead >
                            <tr>
                                <th class="col-md-1 sortable">
                                    顺序
                                </th>
                                <th class="col-md-1 sortable">
                                    <span class="line"></span>名称
                                </th>
                                <th class="col-md-1 sortable">
                                    <span class="line"></span>服务费
                                </th>
                                <th class="col-md-1 sortable ">
                                    <span class="line"></span>最低消费
                                </th>
                                <th class="col-md-1 sortable ">
                                    <span class="line"></span>预定预付款
                                </th>
                                <th class="col-md-1 sortable ">
                                    <span class="line"></span>桌数
                                </th>
                               
                                <th class="col-md-1 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php foreach ($datas as $key => $v) {?>
                        <!-- row -->
                        <tr>
                            <td>
                               <input type="hidden" name="hidd" value="<?php echo $v['id'];?>">
                               <input type="text" class="form-control" placeholder="排序" name="orders" value="<?php  if($v['displayorder']){echo $v['displayorder'];}?>">
                            </td>
                            <td>
                                <?php echo $v['title']?>
                            </td>
                            <td>
                                <?php echo $v['service_rate']?>
                            </td>
                            <td>
                                <?php echo $v['limit_price']?>
                            </td>
                            <td>
                               <?php echo $v['reservation_price']?>
                            </td>
                            <td>
                              <?php  ?>
                            </td>
                            <td>
                              <a href="javascript:;" id="del"  data-id="<?php echo $v['id']?>" >删除</a>
                              |
                              <a href="?r=plugin/shops/index/do_shop_table_type_edit&type_id=<?php echo $v['id']?>">编辑</a>
                            </td>
                        </tr>
                        <!-- row -->
                       <?php }?>
                       
                        
                        </tbody>
                    </table>
                </div>                
            </div>
            <ul class="pagination pull-left">
               
                <a href="javascript:;" id="test" class="btn btn-default daterange daterange-time active"> 批量排序</a>
               
            </ul>
            <!-- end users table -->
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function(){
      $('#test').click(function(){
       var array = $("input[name='orders']");
       var arrayid = $("input[name='hidd']");
       var orders = '';
       var table_id = '';
       for(var i=0;i<array.length;i++){
        var value = $(array[i]).val();
        var ids = $(arrayid[i]).val();
            table_id+=ids+',';
            orders+=value+',';
        }
        var data = {}
        data.orders = orders;
        data.table_id = table_id;
        data._csrf = '<?= Yii::$app->request->csrfToken ?>';

        $.post('?r=plugin/shops/index/table_type_sort',data,function(re){
            
            if (re.error == 0) {
               swal({
                     title: "友情提示！",
                         text: re.msg,
                         type: "success"
                     }, function () {
                            window.location.reload();
                         });
            }else{
                swal('友情提示',re.msg ,'error');

            }

        },'json')
      });
       $('[id=del]').click(function(){
           var id = $(this).data('id');
           var _csrf = '<?= Yii::$app->request->csrfToken ?>';
         if (confirm('你确定要删除吗？')) {
           $.get('?r=plugin/shops/index/table_type_del',{id:id,_csrf:_csrf},function(re){
            console.log(re);
               if (re.error == 0) {
                    swal({
                     title: "友情提示！",
                         text: re.msg,
                         type: "success"
                     }, function () {
                            window.location.reload();
                         });
               }else{
                   swal('友情提示',re.msg ,'error');
               }
           },'json');
       }else{
        return false;
       }
       });
    });
</script>