      <ul id="dashboard-menu">
        <li>                
                <a href="?r=plugin/shops/index/index">
                    <i class="icon-home"></i>
                    <span>首页</span>
                </a>
        </li>
        <?php foreach ($authInfoA as $key => $value) {?>
        
            <li>
                <a class="dropdown-toggle" href="#">
                    <i class="<?php echo $value['auth_url']; ?>"></i>
                    <span><?php echo $value['auth_name'];?></span>
                    <i class="icon-chevron-down"></i>
                </a>
                
                <!-- <ul class="submenu"> -->
                <ul  <?php if(strpos($action,$value['auth_c']) == true){ echo 'class="active submenu"';}else{echo 'class="submenu"';}?>>

                <?php foreach ($authInfoB as $key => $v) {?>
                   <?php if ($value['id'] == $v['auth_pid']): ?>
                       <li><a href="?r=plugin/shops/<?php echo $v['auth_a'];?>/<?php echo $v['auth_c'];?>"  <?php if($v['auth_c'] == $action) echo 'class="active"'?>><?php echo $v['auth_name'];?></a></li>
                   <?php endif ?>
                    
                <?php }?> 
                </ul>
               
            </li>

            <?php }?>
        </ul>