<?php

namespace app\addons\food\publics\controllers;
use Yii;
use yii\web\Controller;
use app\addons\food\models\Food_company;
use app\addons\food\models\Food_employee;
/**
 * Default controller for the `publics` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    //登录入口
    public function actionIndex()
    {
        $this->layout = "layout1";
        return $this->render('index');
    }
    //商家登录
    public function actionSuper_login()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $data1 = Food_company::find()->where(['phone'=>$data['phone']])->one();
            if($data1){
                if($data1['status']==0){
                    $this->dexit(array('error'=>1,'msg'=>'正在审核，请耐心等待'));
                }elseif($data1['status']==2){

                    $this->dexit(array('error'=>2,'msg'=>'你的审核未通过,请修改','cid'=>$data1['id']));
                }elseif($data1['status']==1){
                    //验证密码是否正确
                    if(md5($data['password'])!=$data1['password']) {

                        $this->dexit(array('error'=>1,'msg'=>'密码错误'));
                    }else {

                      //密码正确
                        $session = Yii::$app->session;
                        session_set_cookie_params(3600*24);
                        $session['cid'] = $data1['id'];
                        $session['phone'] = $data1['phone'];
                        $this->dexit(array('error'=>0,'msg'=>'登录成功'));
                    }
                }
            }else{

                $this->dexit(array('error'=>1,'msg'=>'手机号码不存在，请先注册'));
            }
        }
        $this->layout = "layout1";
        return $this->render('super_login');
    }
    //商家申请入住
    public function actionCreate_company()
    {


    	return $this->render('create_company');

    }
    //员工登录
    public function actionShop_login()
    {

         if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $employee = Food_employee::find()->where(['phone'=>$data['phone']])->one();
            if (empty($employee)) {
                $this->dexit(array('error'=>1,'msg'=>'登录名不对'));
            }
            if (md5($data['password']) != $employee['password']) {
                $this->dexit(array('error'=>1,'msg'=>'登录密码不对'));
            }else{
                if($employee['status'] != 1){
                    $this->dexit(array('error'=>1,'msg'=>'禁止登录'));
                }
                $session = Yii::$app->session;
                session_set_cookie_params(3600*24);
                $session['employee'] = $employee;
                $this->dexit(array('error'=>0,'msg'=>'登录成功'));
            }
            //echo 1;
            //die;
        }
        $this->layout = "layout1";
        return $this->render('shop_login');

    }

    public function dexit($data = '')
    {
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
        exit();
    }
}