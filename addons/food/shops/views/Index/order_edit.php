<div class="content">
    <div id="pad-wrapper" class="users-list">
        <table class="table table-bordered">
              <thead>
                <tr>
                  <th>编号</th>
                  <th>商品名称</th>
                  <th>商品数量</th>
                  <th>商品图片</th>
                  <th>掌勺厨师</th>
                  <th>地址</th>
                </tr>
              </thead>
              <tbody>
              <?php
              if(!empty($data1))
              {
                foreach($data1 as $v):
              ?>
                <tr>
                  <th scope="row"><?php echo $v['id']?></th>
                  <td><?php echo $v['goods_name']?></td>
                  <td><?php echo $v['goods_num']?></td>
                  <td><img src="<?php echo $v['goods_img']?>" style="width:50px;height:50px;"></td>
                  <td><?php echo $v['cook']?></td>
                  <td><?php if($data2['eat_type'] == 2){echo $data2['address'];}else{echo '店内';}?></td>
                </tr>
                <?php endforeach;}else{?>
                    暂无数据
                    <?php };?>
                    <tr>
                        <td></td>
                        <td>备注：<?php echo $data2['remark']?></td>
                        <td>总数量：<?php echo $data2['goods_num']?></td>
                        <td>总价：<?php echo $data2['total']?></td>
                        <td></td>
                        <td></td>
                    </tr>
              </tbody>

        </table>
    </div>
</div>