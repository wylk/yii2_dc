<!-- main container -->
<div class="content">
<!-- settings changer -->
<div id="pad-wrapper" class="users-list">
<div class="row header">
    <h3>支付配置列表</h3>
    <div class="col-md-10 col-sm-12 col-xs-12 pull-right">
    <?php if(empty($data)):?>
<a href="?m=plugin&p=admin&cn=index1&id=food:sit:add_payment" class="btn-flat success pull-right"><span>&#43;</span>添加支付配置</a>
    <?php else:?><?php endif;?>
    </div>
</div>
<!-- Users table -->
<div class="row">
<div class="col-md-12">
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-md-1">编号</th>
            <th class="col-md-1">
            <span class="line"></span>appid</th>
            <th class="col-md-1"><span class="line"></span>appsecret</th>
            <th class="col-md-1"><span class="line"></span>商户号</th>
             <th class="col-md-1"><span class="line"></span>创建时间</th>
            <th class="col-md-2"><span class="line"></span>操作</th>
        </tr>
    </thead>
    <tbody>
    <!-- row -->
    <?php if(!empty($data)){foreach($data as $v): ?>
    <tr class="first">
        <td><?php echo $v['id']?></td>
        <td><?php echo $v['appid']?></td>
        <td><?php echo $v['appsecret']?></td>
        <td><?php echo $v['mch_id']?></td>
        <td><?php echo date('Y-m-d H:i:s',$v['addtime'])?></td>
        <td>
        <a href="?m=plugin&p=admin&cn=index1&id=food:sit:edit_payment&pid=<?php echo $v['id']?>"><button class="btn btn-primary" onclick="if(confirm('是否确认修改？')==false)return false;">修改</button></a>
        <a href="?m=plugin&p=admin&cn=index1&id=food:sit:del_payment&pid=<?php echo $v['id']?>"><button class="btn btn-danger" onclick="if(confirm('是否确认删除？')==false)return false;">删除</button></a>
        </td>
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