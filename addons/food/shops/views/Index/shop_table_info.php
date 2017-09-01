
    <div class="content">
        <!-- settings changer -->
        <div id="pad-wrapper" class="new-user">
            <div class="row form-wrapper">
                <!-- left column -->
                <div class="col-md-9 with-sidebar" style="border-right: 1px solid #fff;padding-left: 85px">
                    <div class="container">
                        <div class="main">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a class="btn btn-warning" href="?r=plugin/shops/index/do_shop_table">
                                        返回餐桌管理
                                    </a>
                                </div>
                            </div>
                            <style type="text/css">
                                .span-left{
                                    width: 100px;

                                }
                                .span-right{
                                    float:right;
                                    color: red;
                                }
                            </style>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                                <input type="hidden" name="storeid" value="2" />
                                <input type="hidden" name="id" value="" />
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                             桌台 详情
                                    </div>
                                    <div class="panel-body">

                                        <div class="list-group-item">
                                                <span class="span-left">名字(桌台号) :</span>
                                                <span class="span-right"><?php echo $datas[0]['title']?></span>
                                        </div>

                                       <div class="list-group-item">
                                                <span class="span-left">标签：</span>
                                                <span class="span-right"><?php echo $datas[0]['c_title']?></span>
                                        </div>
                                        <div class="list-group-item">
                                                桌台类型 :
                                                <span class="span-right"><?php echo $datas[0]['b_title']?></span>
                                        </div>
                                        <div class="list-group-item">
                                               可供就餐人数 :
                                               <span class="span-right"><?php echo $datas[0]['user_count']?></span>
                                        </div>
                                        <div class="list-group-item">
                                                当前状态 :
                                                <span class="span-right">
                                                <?php if($datas[0]['status'] == 1){?>
                                                    已开台
                                                <else if($datas[0]['status'] == 2){>
                                                    已下单
                                                <else if($datas[0]['status'] == 3){>
                                                    已支付
                                                <?php }else{?>
                                                    空闲
                                                <?php }?>
                                                </span>
                                        </div>
                                        <div class="list-group-item">
                                                扫描次数 :
                                                <span class="span-right"><?php echo $datas[0]['displayorder'];?></span>
                                        </div>
                                        <div class="list-group-item">
                                                排序 :
                                                <span class="span-right"><?php echo $datas[0]['displayorder'];?></span>
                                        </div>
                                        <div class="list-group-item">
                                                二维码图片 :
                                                <div style="width:200px;height:200px;border:1px dashed #dddddd;    margin-left: 13%; " id="qr-code-autopay">
                                                <img src="<?php echo $datas[0]['url']?>" alt="">
                                                </div>
                                        </div>



                                    </div>
                                    <div class="form-group col-sm-12" style="margin-top: 20px;">
                                        <a href="?r=plugin/shops/index/do_shop_table_edit&table_id=<?php echo $datas[0]['id'];?>" id="add1" class="btn btn-default col-lg-3">
                                            修改
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo FOOD_PATH;?>js/jquery.qrcode.min.js">
        </script>
        <script type="text/javascript">
            $(function() {
                var qheight = qwidth = 200;
                $("#qr-code-autopay").html('').css('background-color','#FFF').qrcode({
                    //render: "table", //table方式
                    width: qwidth, //宽度
                    height: qheight, //高度
                    text:'https://www.baidu.com/' //任意内容
                });

            });
        </script>
        </body>

        </html>