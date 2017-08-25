<!-- main container -->
<div class="content">
<!-- settings changer -->
<div id="pad-wrapper" class="users-list">
<div class="row header">
    <h3>门店类型</h3>
    <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
    <form action="?m=plugin&p=admin&cn=index1&id=food:sit:shop_type" method="post">
        <input type="text" class="col-md-5 search" placeholder="输入门店类型名称" name="typename" value="<?php echo $data2['typename']?>">
        <input type="submit" value="搜索" style="margin-top: 12px;">
     </form>
    <a href="?m=plugin&p=admin&cn=index1&id=food:sit:create_shop_type" class="btn-flat success pull-right"><span>&#43;</span>创建门店类型</a>
    </div>
</div>
<!-- Users table -->
<div class="row">
<div class="col-md-12">
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-md-2">编号</th>
            <th class="col-md-2"><span class="line"></span>名称</th>
            <th class="col-md-2"><span class="line"></span>图标</th>
            <th class="col-md-3"><span class="line"></span>创建时间</th>
            <th class="col-md-3"><span class="line"></span>操作</th>
        </tr>
    </thead>
    <tbody>
    <!-- row -->
        <?php if(!empty($data)){foreach($data as $v): ?>
        <tr class="first">
            <td><?php echo $v['id']?></td>
            <td><?php echo $v['typename']?></td>
            <td><a rel="example_group" href="<?php echo $v['type_img']?>"><img src="<?php echo $v['type_img']?>" alt="" style="width:50px;height:50px;"></a></td>
            <td><?php echo date('Y-m-d H:i:s',$v['create_time']) ?></td>
            <td><a href="?m=plugin&p=admin&cn=index1&id=food:sit:shop_type_edit&sid=<?php echo $v['id'];?>"><button class="btn btn-primary" onclick="if(confirm('是否确定修改？')==false)return false;">修改</button></a>
            <a href="?m=plugin&p=admin&cn=index1&id=food:sit:shop_type_del&sid=<?php echo $v['id'];?>"><button class="btn btn-danger" onclick="if(confirm('是否确定删除？')==false) return false;">删除</button></a></td>
        </tr>
        <?php endforeach;}else{?>暂无数据<?php };?>
    </tbody>
</table>
</div>
</div>
<td colspan="12"><?php echo $pagebar;?></td>
<!-- end users table -->
</div>
</div>
</body>
</html>