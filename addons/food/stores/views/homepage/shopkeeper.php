<div class="content">
<!-- settings changer -->
<div id="pad-wrapper" class="users-list">
<div class="row header">
<h3>门店类型</h3>
<div class="col-md-10 col-sm-12 col-xs-12 pull-right">
<form action="" method="post">
<input type="text" class="col-md-5 search" placeholder="输入店长真实姓名" name="truename" value="<?php echo $data2['truename']?>">
<input type="submit" value="搜索" style="margin-top: 12px;">
 </form>
<a href="?m=plugin&p=admin&cn=index1&id=food:sit:create_employee" class="btn-flat success pull-right"><span>&#43;</span>创建店长账号</a>
</div>
</div>
<!-- Users table -->
<div class="row">
<div class="col-md-12">
<table class="table table-hover">
    <thead>
        <tr>
            <th class="col-md-1">编号</th>
            <th class="col-md-1"><span class="line"></span>店长姓名</th>
            <th class="col-md-1"><span class="line"></span>所属门店</th>
            <th class="col-md-1"><span class="line"></span>真实姓名</th>
            <th class="col-md-1"><span class="line"></span>手机号码</th>
            <th class="col-md-1"><span class="line"></span>电子邮箱</th>
            <th class="col-md-1"><span class="line"></span>状态</th>
            <th class="col-md-2"><span class="line"></span>备注</th>
            <th class="col-md-2"><span class="line"></span>操作</th>
        </tr>
    </thead>
<tbody>
<!-- row -->
        <?php if(!empty($data)){foreach($data as $v): ?>
        <tr class="first">
            <td><?php echo $v['id']?></td>
            <td><?php echo $v['username']?></td>
            <td><?php echo $v['shop_name']?></td>
            <td><?php echo $v['truename']?></td>
            <td><?php echo $v['phone']?></td>
            <td><?php echo $v['email']?></td>
            <td><?php
            if($v['status']==1)
                echo '开启';
            else
                echo '关闭';

            ?></td>
            <td><?php echo $v['remark']?></td>
            <td>
            <a href="?m=plugin&p=admin&cn=index1&id=food:sit:employee_edit&bid=<?php echo $v['id']?>"><button class="btn btn-primary" onclick="if(confirm('是否确认修改？')==false)return false;">修改</button></a>
            <a href="?m=plugin&p=admin&cn=index1&id=food:sit:employee_del&bid=<?php echo $v['id']?>"><button class="btn btn-danger" onclick="if(confirm('是否确认删除？')==false)return false;">删除</button></a>
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
