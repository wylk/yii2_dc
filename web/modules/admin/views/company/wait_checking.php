<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'My Yii Application';

?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">

                <div class="ibox-content">
                    <div class="row">
                    <div class="col-sm-3">
                        <a class="btn btn-info btn-sm" href="<?= Url::toRoute('user/create')?>">新增用户</a>
                    </div>
                    </div>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>公司名称</th>
                                <th>公司地址</th>
                                <th>法人姓名</th>
                                <th>营业执照号</th>
                                <th>营业执照</th>
                                <th>身份证号</th>
                                <th>身份证正面</th>
                                <th>身份证反面</th>
                                <th>手机号码</th>
                                <th>电子邮箱</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($data as $vo):?>
                                <tr>
                                    <td><?=$vo['id']?></td>
                                    <td><?=$vo['company_name']?></td>
                                    <td><?=$vo['company_address']?></td>
                                    <td><?=$vo['company_person']?></td>
                                    <td><?=$vo['licence']?></td>
                                    <td><img src="<?=$vo['licence_path']?>" style="width:50px;height:50px;"></td>
                                    <td><?=$vo['cart_number']?></td>
                                    <td><img src="<?=$vo['frontal_view']?>" alt="" style="width:50px;height:50px;"></td>
                                    <td><img src="<?=$vo['back_view']?>" alt="" style="width:50px;height:50px;"></td>
                                    <td><?=$vo['phone']?></td>
                                    <td><?=$vo['email']?></td>
                                    <td><?=date('Y-m-d H:i:s',$vo['addtime'])?></td>
                                    <td><a class="btn btn-primary btn-xs" href="<?=Url::toRoute(['company/pass','id'=>$vo['id']])?>" onclick="if(confirm('是否确定通过审核？')==false)return false;"><i class="fa fa-edit"></i>通过</a>  <a href="<?=Url::toRoute(['company/reject','id'=>$vo['id']])?>" onclick="if(confirm('是否确定驳回？')==false)return false;" class="btn btn-default btn-xs"><i class="fa fa-close"></i>驳回</a></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <!--分页-->
                        <div class="f-r">
                            <?= LinkPager::widget([
                                'pagination'=>$pages,
                                'firstPageLabel' => '首页',
                                'nextPageLabel' => '下一页',
                                'prevPageLabel' => '上一页',
                                'lastPageLabel' => '末页',
                            ]) ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
