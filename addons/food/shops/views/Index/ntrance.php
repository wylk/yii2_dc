<?php 
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
                <h3>角色列表</h3>
                <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
                    <!-- <input type="text" class="col-md-5 search" placeholder="输入姓名查询"> -->

                    <!-- custom popup filter -->
                    <!-- styles are located in css/elements.css -->
                    <!-- script that enables this dropdown is located in js/theme.js -->
                    <a href="?r=plugin/shops/index/do_employee_role_add" class="btn-flat success pull-right">
                        <span>&#43;</span>
                       添加角色
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
                                    序号
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>角色名称
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>权限id
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>role_auth_ac
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>菜品分类权限
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php foreach ($role as $key => $v) {?>
                        <!-- row -->
                        <tr>
                            <td>
                                <?php echo $v['id']?>
                            </td>
                            <td>
                                <?php echo $v['role_name']?>
                            </td>
                            <td>
                               <?php echo substr($v['role_auth_ids'],0,8)?>
                            </td>
                            <td >
                               <?php echo substr($v['role_auth_ac'],0,8)?>
                            </td>
                             <td >
                              <?php if($v['cat_id'])
                                  echo $v['cat_id'];
                                else
                                  echo '暂无分配权限';
                              ?>

                            </td>
                            <td>
                              <a href="javascript:;" id="del"  data-id="<?php echo $v['id']?>" >删除</a>
                              |
                              <a href="?r=plugin/shops/index/edit_ntrance_cat_id&role_id=<?php echo $v['id'];?>">编辑</a>
                            </td>
                        </tr>
                        <!-- row -->
                       <?php }?>


                        </tbody>
                    </table>
                </div>
            </div>
            <?= LinkPager::widget([
              'pagination'=>$pages,
              'firstPageLabel' => '首页',
              'nextPageLabel' => '下一页',
              'prevPageLabel' => '上一页',
              'lastPageLabel' => '末页',
            ]) ?>
        </div>
    </div>
</body>
</html>

<script type="text/javascript">
    $(function(){
       $('[id=del]').click(function(){
           var id = $(this).data('id');
           var _csrf = '<?= Yii::$app->request->csrfToken ?>';
          if (confirm('你确定要删除吗？')) {
           $.get('?r=plugin/shops/index/empolyee_role_del',{id:id,_csrf:_csrf},function(re){
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