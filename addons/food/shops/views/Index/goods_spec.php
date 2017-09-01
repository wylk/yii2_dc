<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
    <div class="content">

        <!-- settings changer -->
        <div id="pad-wrapper" class="users-list">
            <div class="row header">
                <h3>规格列表</h3>
                <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
                <form method="post">
                    <input type="text" class="col-md-5 search" name="spec_name" placeholder="输入规格名称" value="<?php echo $data2['spec_name']?>">
                    <input type="submit" value="搜索" style="
                        position: relative;
                        top: 10px;
                        left: 0px;">
                    </form>
                    <a href="?r=plugin/shops/index/do_goods_spec_add" class="btn-flat success pull-right">
                        <span>&#43;</span>
                       添加规格
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
                                    编号
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>规格名称
                                </th>
                                <th class="col-md-2 sortable">
                                    <span class="line"></span>属性值
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>排序
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>创建时间
                                </th>
                                <th class="col-md-1 sortable ">
                                    <span class="line"></span>状态
                                </th>
                                <th class="col-md-2 sortable ">
                                    <span class="line"></span>操作
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                     <?php

                     if(!empty($data))
                     {

                        foreach ($data as $key => $v):


                      ?>
                        <!-- row -->
                        <tr>
                            <td>
                                <?php echo $v['id']?>
                            </td>
                            <td>
                                <?php echo $v['spec_name']?>
                            </td>
                            <td>
                               <?php
                                $data1=json_decode($v['spec_value'],true);
                                foreach($data1 as $v1)
                                {
                                    echo '属性值='.$v1['spec_name'].',比例='.$v1['proportion']."<br>";
                                }


                                ;?>
                            </td>
                            <td>
                                <?php echo $v['sort']?>
                            </td>
                            <td>

                               <?php echo date('Y-m-d H:i:s',$v['addtime'])?>
                            </td>

                            <td>
                              <?php if($v['status'] == 0){ echo '关闭';}else{ echo '开启';} ?>
                            </td>
                            <td>
                              <a href="javascript:;" id="del"  data-id="<?php echo $v['id']?>">删除</a>
                              |
                              <a href="?r=plugin/shops/index/do_goods_spec_edit&cid=<?php echo $v['id']?>" onclick="if(confirm('是否确定编辑？')==false)return false;">编辑</a>
                            </td>
                        </tr>
                        <!-- row -->
                       <?php endforeach;}else{?>
                        暂无数据
                        <?php };?>
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
        if(confirm('是否确定删除?')==false)
        {
            return false;
        }
           var id = $(this).data('id');
           var _csrf = '<?= Yii::$app->request->csrfToken ?>';
           $.get('?r=plugin/shops/index/do_spec_del',{del_id:id,_csrf:_csrf},function(re){
            console.log(re);
               if (re.error == 0) {
                    alert(re.msg);
                     window.location.reload();
               }else{
                    alert(re.msg);
               }
           },'json');
       });
    });
</script>