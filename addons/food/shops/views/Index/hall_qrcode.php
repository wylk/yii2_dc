
  <style type="text/css">

 .sortable{
     text-align: center;
 }
  </style>

    <!-- main container -->
   <div class="content">

        <!-- settings changer -->
        <div id="pad-wrapper" class="users-list">

            <!-- Users table -->
            <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-default">
    <div class="panel-body">
        <div class="header">
            <h3>
                大厅选桌二维码
            </h3>
        </div>

        <style type="text/css">
            .state-table{
                float: left;
                height: 250px;
                width: 180px;
                margin-right:2%;
            }
            .state{
                border:1px solid #dddddd;
                height: 170px;
                width: 100%;
                text-align: center;
                line-height: 80px;
                color: white;
                font-size: 16px;

            }

            .table_title{

            }
            .overflow-ellipsis{
                background-color: #eeeeee;
                text-align: center;
                padding-top: 8px;

            }

            #qr-code-autopay{
                /* border: 1px dashed #dddddd; */
                width: 90%;
                height:90%;
                margin: 5% 5%;

            }
            img{
                width: 100%;
                height:100%;
            }

        </style>
        <div id="queue-setting-index-body">
            <div class="table-state-tables">
                <div class="col-xs-12">
            <!--  餐桌 -->


                    <div class="state-table" data-id="">
                        <a class="idle round" href="javascript:;"
                        data-remote="">
                            <div class="state">
                                <div id="qr-code-autopay">
                                   <img src="https://lepay.51ao.com/pay/api/apiqrcode.php?url=<?php echo base64_encode('https://baidu.com');?>"/>
                                </div>
                            </div>
                        </a>

                        <div class="name overflow-ellipsis">
                        <a download href="https://lepay.51ao.com/pay/api/apiqrcode.php?url=https://www.baidu.com" target="_blank" ><span class="glyphicon glyphicon-download-alt" style="float: left;margin-left:6px; " ></span></a>
                        </div>
                    </div>


                    <!-- 餐桌end -->

                </div>
                <div class="col-xs-4">
                    <div class="table-order">
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <div class="clearfix">
            </div>
        </div>
    </div>
</div>

            </div>
            <!-- end users table -->
        </div>
    </div>
</body>
</html>

