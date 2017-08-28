<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
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
                <h3>员工列表</h3>
                <div class="col-md-10 col-sm-12 col-xs-12 pull-right">


                    <!-- custom popup filter -->
                    <!-- styles are located in css/elements.css -->
                    <!-- script that enables this dropdown is located in js/theme.js -->
                    <a href="?r=plugin/shops/index/do_employee_add" class="btn-flat success pull-right">
                        <span>&#43;</span>
                       添加员工
                    </a>
                </div>
            </div>

            <!-- Users table -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover" style="text-align: center">
                        <thead >
                            <tr>
                                <th class="col-md-2 sortable">
                                    真实姓名
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>电话号码
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>邮箱
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>角色
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>状态
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php foreach ($employees as $key => $v) {?>
                        <!-- row -->
                        <tr>
                            <td>
                                <?php echo $v['truename']?>
                            </td>
                            <td>
                                <?php echo $v['phone']?>
                            </td>
                            <td>
                               <?php echo $v['email']?>
                            </td>
                            <td >
                               <?php echo $v['role_name']?>
                            </td>
                            <td>
                              <?php if($v['status'] == 1){ echo '正常';}else{ echo '停用';} ?>
                            </td>
                            <td>
                              <a href="javascript:;" id="del"  data-id="<?php echo $v['id']?>" >删除</a>
                              |
                              <a href="?r=plugin/shops/index/do_employee_edit&employee_id=<?php echo $v['id']?>">编辑</a>
                            </td>
                        </tr>
                        <!-- row -->
                       <?php }?>


                        </tbody>
                    </table>
                </div>
            </div>

           <td colspan="12">
           <?= LinkPager::widget([
              'pagination'=>$pages,
              'firstPageLabel' => '首页',
              'nextPageLabel' => '下一页',
              'prevPageLabel' => '上一页',
              'lastPageLabel' => '末页',
            ]) ?>
             
           </td>

        </div>
    </div>
    <!-- end main container -->
</body>
</html>

<script type="text/javascript">
    $(function(){
      $('#test').click(function(){
       swal("友情提示！", "操作成功","success");
      });
       $('[id=del]').click(function(){
           var id = $(this).data('id');
           var _csrf = '<?= Yii::$app->request->csrfToken ?>';
         if (confirm('你确定要删除吗？')) {
           $.get('?r=plugin/shops/index/do_empolyee_del',{id:id,_csrf:_csrf},function(re){
            console.log(re);
               if (re.error == 0) {
                    alert(re.msg);
                    
                    window.location.reload();
               }else{
                    alert(re.msg);
               }
           },'json');
       }else{
        return false;
       }
       });
    });
</script>