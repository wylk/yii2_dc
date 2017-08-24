<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>公司信息</title>

    <link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="<?php echo FOOD_PATH?>css/bootstrap/bootstrapValidator.min.css" rel="stylesheet">

    <script src="<?php echo FOOD_PATH?>js/jquery-1.10.2.min.js"></script>

    <script src="<?php echo FOOD_PATH?>js/bootstrap.min.js"></script>
    <script src="<?php echo FOOD_PATH?>js/bootstrapValidator.min.js"></script>
</head>
<body>
<!-- <h3 style="text-align:center;"></h3> -->
<div class="container">
    <div class="row">
    <section>
    <div class="col-lg-8 col-lg-offset-2">
    <div class="page-header">
    <h2>请上传公司信息</h2>
</div>
    <form id="defaultForm" method="post" class="form-horizontal" action="?r=plugin/publics/default/create_company" enctype="multipart/form-data">

  <div class="form-group">
    <label for="company_name">公司名称</label>
    <div class="col-lg-12">
    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="公司名称">
    </div>
  </div>
   <div class="form-group">
    <label for="company_address">公司地址</label>
     <div class="col-lg-12">
    <input type="text" class="form-control" id="company_address" name="company_address" placeholder="公司地址">
    </div>
  </div>
   <div class="form-group">
    <label for="company_person">法人姓名</label>
     <div class="col-lg-12">
    <input type="text" class="form-control" id="company_person" name="company_person" placeholder="法人姓名">
    </div>
  </div>
   <div class="form-group">
    <label for="licence">营业执照号码</label>
    <div class="col-lg-12">
    <input type="text" class="form-control" id="licence" name="licence" placeholder="营业执照号码">
    </div>
  </div>
   <div class="form-group">
    <label for="licence_path">营业执照</label>
     <div class="col-lg-12">
    <input type="file" id="licence_path" name="licence_path">
    </div>

  </div>
  <div class="form-group">
    <label for="cart_number">身份证号码</label>
    <div class="col-lg-12">
    <input type="text" class="form-control" id="cart_number" name="cart_number" placeholder="身份证号码">
    </div>
  </div>
  <div class="form-group">
    <label for="frontal_view">身份证正面照</label>
    <div class="col-lg-12">
    <input type="file" id="frontal_view" name="frontal_view">
    </div>

  </div>


  <div class="form-group">
    <label for="back_view">身份证反面照</label>
    <div class="col-lg-12">
    <input type="file" id="back_view" name="back_view">
    </div>

  </div>

  <div class="form-group">
    <label for="password">登录密码</label>
    <div class="col-lg-12">
    <input type="password" class="form-control" id="password" name="password" placeholder="登录密码">
    </div>
    </div>
    <div class="form-group">
    <label for="repass">确认密码</label>
    <div class="col-lg-12">
    <input type="password" class="form-control" id="repass" name="repass" placeholder="确认密码">
    </div>
  </div>
  <div class="form-group">
    <label for="email">电子邮箱</label>
    <div class="col-lg-12">
    <input type="email" class="form-control" id="email" name="email" placeholder="电子邮箱">
    </div>
  </div>

  <div class="form-group">
    <label for="phone">手机号码</label>
    <div class="col-lg-12">
    <input type="text" class="form-control" id="phone" name="phone" placeholder="手机号码" style="width: 70%"><a href="javascript:;" class="btn btn-default" style="float: right;margin-top: -31px; width: 14%;" id="getCodeBtn"> 获取验证码</a>
    <p class="help-block">手机号码是作为商家登录的账号，请填写真实有效的手机号码。</p>
    </div>
  </div>
  <div class="form-group">
    <label for="code">验证码</label>
    <div class="col-lg-12">
    <input type="text" class="form-control" id="code" name="code" placeholder="验证码">
    </div>
  </div>
  <button type="submit" class="btn btn-default">确定提交</button>
  <button type="button" class="btn btn-info" id="resetBtn">重置表单</button>
</form>
<br><br><br><br><br><br>
</div>
</section>
</div>
</div>
</body>
</html>
<script>
$(document).ready(function(){
    $('#defaultForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields:{
            company_name:{
                message: 'The username is not valid',
                validators:{
                    notEmpty:{
                        message:'公司名称不能为空'
                    },
                    stringLength:{
                        min:4,
                        max:30,
                        message:'公司名称在4-30个字符之间'
                    },
                    threshold:4,
                    remote:{
                        url:"?m=plugin&p=public&cn=index&id=food:sit:validate_company_name",
                        message:"公司名称已存在",
                        delay:2000,
                        type:"POST"
                    },
                    regexp:{
                        regexp:/^([A-Za-z]|[\u4E00-\u9FA5]|[\u4e00-\u9fa5a-zA-Z])+$/,
                        message:'公司名称只能是英文或中文或中英文组合'
                    }
                }
            },
            company_address:{
                message:'the company_address is not valid',
                validators:{
                    notEmpty:{
                        message:'公司地址不能为空'
                    }
                }
            },
            company_person:{
                message:'the company_person is not valid',
                validators:{
                    notEmpty:{
                        message:'法人姓名不能为空'
                    },
                    regexp:{
                        regexp:/^([A-Za-z]|[\u4E00-\u9FA5])+$/,
                        message:'法人姓名只能是中文或英文'
                    }
                }
            },
            licence:{
                message:'the licence is not valid',
                validators:{
                    notEmpty:{
                        message:'营业执照号码不能为空'
                    }
                }
            },
            licence_path:{
                message:'the licence_path is not valid',
                validators:{
                    notEmpty:{
                        message:'请上传营业执照图片'
                    }
                }
            },
            cart_number:{
                message:'the cart_number is not valid',
                validators:{
                    notEmpty:{
                        message:'身份证号码不能为空'
                    },
                    regexp:{
                        regexp:/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/,
                        message:'身份证格式不正确'
                    }
                }
            },
            frontal_view:{
                message:'the frontal_view is not valid',
                validators:{
                    notEmpty:{
                        message:'请上传身份证正面照'
                    }
                }
            },
            back_view:{
                message:'the back_view is not valid',
                validators:{
                    notEmpty:{
                        message:'请上传身份证背面照'
                    }
                }
            },
            phone:{
                message:'the phone is not valid',
                validators:{
                    notEmpty:{
                        message:'手机号码不能为空'
                    },
                    stringLength:{
                        min:11,
                        max:11,
                        message:'请输入11位手机号码'
                    },
                    regexp:{
                        regexp:/^1[3,4,5,7,8]\d{9}$/,
                        message:'手机号码格式不正确'
                    }
                }
            },
            password:{
                message:'the password is not valid',
                validators:{
                    notEmpty:{
                        message:'登录密码不能为空'
                    },
                    stringLength:{
                        min:6,
                        max:18,
                        message:'请输入6-18位登录密码'
                    }
                }
            },
            repass:{
                message:'the repass is not valid',
                validators:{
                    notEmpty:{
                        message:'确认密码不能为空'
                    },
                    identical:{
                        field:'password',
                        message:'两次密码输入不一致'
                    }
                }
            },
            email:{
                message:'the email is not valid',
                validators:{
                    notEmpty:{
                        message:'电子邮箱不能为空'
                    },
                    emailAddress:{
                        message:'电子邮箱格式不正确'
                    }
                }
            },
            code:{
                message:'the code is not valid',
                validators:{
                    notEmpty:{
                        message:'验证码不能为空'
                    }
                }
            }
        }
    });
    $('#validateBtn').click(function() {
        $('#defaultForm').bootstrapValidator('validate');

    });
    $('#resetBtn').click(function() {
        $('#defaultForm').data('bootstrapValidator').resetForm(true);
    });
});

</script>
<script type="text/javascript">
    
      var itime = 60;//定义一个变量，倒计时初始化，从59秒开始
        function getTime(){
            if(itime>=0){
                if(itime==0){
                    clearTimeout(act);
                    $("#getCodeBtn").html('获取验证码').attr('disabled',false);
                     itime=60;
                }else{
                    var act =  setTimeout('getTime()',1000);
                    $("#getCodeBtn").html('还剩'+itime+'秒');
                    itime=itime-1;
                }
            }
        }

     $(function(){
        $("#getCodeBtn").click(function(){
            var tel = $("#phone").val();
            if(tel == ''){
                alert('请先输入有效的手机号码'); return false;
            }
            $.get('?m=plugin&p=public&cn=index&id=food:sit:message',{tel:tel},function(re){
                if(re.error == 0){
                    //调用接口已经成功
                    alert('短信验证码已经发送成功');
                    $("#getCodeBtn").attr('disabled',true);    //要禁用该按钮
                    //调用一个函数，完成倒计时效果。
                    getTime();
                }else{
                    alert('发送失败');
                }
            },'json');
        });
});       
</script>