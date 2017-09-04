<!-- main container -->
<div class="content">
<!-- settings changer -->
<div id="pad-wrapper" class="users-list">
<div class="row header">
    <h3>门店管理</h3>
    <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
    <form  method="post">
        <input type="hidden" name="_csrf"  value="<?php echo \Yii::$app->request->csrfToken?>">
        <input type="text" class="col-md-5 search" placeholder="请输入门店名称" name="shop_name" value="<?php if(isset($data1['shop_name']))
                {
                    echo $data1['shop_name'];
                }
                else
                    echo '';
                ?>">
        <input type="submit" value="搜索" style="margin-top: 12px;">
    </form>
    <a href="<?php echo yii\helpers\Url::to(['homepage/create_shop'])?>" class="btn-flat success pull-right">
    <span>&#43;</span>
    创建门店
    </a>
    </div>
</div>
<?php
    if (Yii::$app->session->hasFlash('info')) {
                                    echo Yii::$app->session->getFlash('info');
                                }
?>
<!-- Users table -->
<div class="row">
<div class="col-md-12">
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-md-1 sortable">编号</th>
            <th class="col-md-1 sortable"><span class="line"></span>门店名称</th>
            <th class="col-md-1 sortable"><span class="line"></span>门店类型</th>
            <th class="col-md-1 sortable"><span class="line"></span>门店状态</th>
            <th class="col-md-1 sortable"><span class="line"></span>门店公告</th>
            <th class="col-md-1 sortable align-left"><span class="line"></span>人均消费</th>
            <th class="col-md-1 sortable align-left"><span class="line"></span>门店地址</th>
            <th class="col-md-1 sortable align-left"><span class="line"></span>门店简介</th>
            <th class="col-md-1 sortable align-left"><span class="line"></span>创建时间</th>
            <th class="col-md-2 sortable align-left"><span class="line"></span>操作</th>
            <th class="col-md-1 sortable align-left"><span class="line"></span>管理</th>
        </tr>
    </thead>
    <tbody>
    <!-- row -->
    <?php if(!empty($data)){foreach($data as $v): ?>
    <tr class="first">
        <td><?php echo $v['id'];?></td>
        <td><?php echo $v['shop_name'];?></td>
        <td><?php echo $v['typename']?></td>
        <td class="align-left">
         <?php if($v['shop_status']==1) echo '开启'; else echo '关闭';?></td>
         <td class="align-left"><?php echo $v['shop_notice'];?></td>
         <td class="align-left"><?php echo $v['cost_per']?></td>
         <td class="align-left"><?php echo $v['shop_address']?></td>
         <td class="align-left"><?php echo $v['shop_introduction']?></td>
         <td class="align-left"><?php echo date('Y-m-d H:i:s',$v['add_time'])?></td>
         <td class="align-right">
          <a href="<?php echo yii\helpers\Url::to(['homepage/shop_edit','bid'=>$v['id']])?>" class="btn btn-success" onclick="if(confirm('是否确认修改？')==false)return false;">修改</a>
          <a href="<?php echo yii\helpers\Url::to(['homepage/shop_del','bid'=>$v['id']])?>" class="btn btn-danger" onclick="if(confirm('是否确认删除？')==false)return false;">删除</a>
        </td>
<<<<<<< HEAD
        <td><a href="r=plugin/shops/index/index&store_id=<?php echo $v['id']?>" class="btn btn-success">进入店铺</a></td>
=======
        <td><a href="?r=plugin/shops/index/index&store_id=<?php echo $v['id']?>" class="btn btn-success">进入店铺</a></td>
>>>>>>> b2a9c655757ee404bb13b6ccd2270140994b410f

    </tr>
    <?php endforeach;}else{?>暂无数据<?php };?>
    </tbody>
</table>
</div>
</div>
<?php echo yii\widgets\LinkPager::widget([
                        'pagination' => $pager,
                        'prevPageLabel' => '&#8249;',
                        'nextPageLabel' => '&#8250;',
                    ]); ?>
<!-- end users table -->
</div>
</div>
</body>
</html>