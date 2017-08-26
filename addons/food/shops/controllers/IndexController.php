<?php

namespace app\addons\food\shops\controllers;

use Yii;
use app\addons\food\shops\controllers\CommonController;
use app\addons\food\models\Food_store_auth;
use yii\data\Pagination;
use app\addons\food\models\Food_employee;
use app\addons\food\models\Food_store_role;
use app\addons\food\models\Food_shop;
use app\vendor\org\CommonApi;
class IndexController extends CommonController
{
    public function actionTest()
    {
        $data = new Common();
        $data->index();
    }
   
    public function actionIndex()
    {
    	//$session = Yii::$app->session;
    	//var_dump($session->get('employee'));
        return $this->render('index');
    }

    public function actionLeft_menu()
    {
    	if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
    	}
    	$this->layout = 'layout2';
        if (isset(Yii::$app->session['cid']) || Yii::$app->session['employee']['role_id'] == 0) {
        	$authInfoA = Food_store_auth::find()->where(['auth_level'=>0,'is_show'=>1])->asArray()->orderBy('id asc')->all();
        	$authInfoB = Food_store_auth::find()->where(['auth_level'=>1,'is_show'=>1])->asArray()->orderBy('id asc')->all(); 
            //$authInfoA = model('store_auth')->where(array('auth_level'=>0,'is_show'=>1))->order('id asc')->select();
            //$authInfoB = model('store_auth')->where(array('auth_level'=>1,'is_show'=>1))->order('id asc')->select();
        }else{
           /* $role= model('store_role')->where(array('store_id'=>$this->mid,'id'=>$_SESSION['employee']['role_id']))->find();
            $authInfoA = model('store_auth')
                    ->where(array(
                        'auth_level'=>0,
                        'is_show'=>1,
                        'id'=>array('in',$role['role_auth_ids'])))
                    ->select();

            //var_dump($authInfoA);die
            $authInfoB = model('store_auth')
                    ->where(array(
                        'auth_level'=>1,
                        'is_show'=>1,
                        'id'=>array('in',$role['role_auth_ids'])))
                    ->select();*/
        }
       	return $this->render('left_menu',['authInfoA'=>$authInfoA,'authInfoB'=>$authInfoB,'action'=>$data['action']]);
    }
    //员工列表
    public function actionDo_employee_list()
    {
        //$shop_id = Yii::$app->session['employee']['shop_id'];
        $shop_id =7;
        $data = Food_employee::find()->where(['shop_id'=>$shop_id])->andwhere('status <> 2')->andwhere('role_id > 0');
        $pages = new Pagination(['totalCount' => $data->count(),'pageSize' => '10']);
        $employees = $data->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        foreach ($employees as $key => &$v) {
            $roles = Food_store_role::find()->where(['store_id'=>$shop_id,'id'=>$v['role_id']])->asArray()->one();
            $v['role_name'] = $roles['role_name'];
        }
        return $this->render('employee_list',['employees'=>$employees,'pages'=>$pages]);
    }
    //删除员工do_empolyee_del
    public function actionDo_empolyee_del()
    {
        $id = Yii::$app->request->get()['id'];
        $data = Food_employee::findOne($id);
        $data->status = 2;
        if($data->save()) {
           $this->dexit(array('error'=>0,'msg'=>'删除成功'));
        }else{
            $this->dexit(array('error'=>1,'msg'=>'删除失败'));
        }
    }

    //添加员工
    public function actionDo_employee_add()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $data['shop_id'] = Yii::$app->session['employee']['shop_id'];
            $data['remark'] = '员工';
            $employee = Food_employee::find()->where(['truename'=>$data['truename']])->andwhere('status <> 2')->one();
            if ($employee) {
               $this->dexit(array('error'=>1,'msg'=>'真实姓名也存在'));
            }
            $employee1 = Food_employee::find()->where(['username'=>$data['username']])->andwhere('status <> 2')->one();
            if ($employee1) {
               $this->dexit(array('error'=>1,'msg'=>'登录账号也存在'));
            }
            $employee2 = Food_employee::find()->where(['phone'=>$data['phone']])->andwhere('status <> 2')->one();
            if ($employee2) {
               $this->dexit(array('error'=>1,'msg'=>'手机号码也存在'));
            }
            $employee3 = Food_employee::find()->where(['email'=>$data['email']])->andwhere('status <> 2')->one();
            if ($employee3) {
               $this->dexit(array('error'=>1,'msg'=>'邮箱号码也存在'));
            }
            $password = $data['password'];
            $data['password'] = md5($data['password']);

            $time = time();
            $data['create_time'] = $time;
            //Yii::$app->session['employee']['shop_id']
            $shop = Food_shop::find()->where(['id'=>Yii::$app->session['employee']['shop_id']])->asArray()->one();
            $data['company_id'] = $shop['company_id'];
            //添加到用户表
            $user = new CommonApi();;
            $res = $user->add_user($password,$data['username'],'','','');
            $this->dexit(array('error'=>1,'msg'=>$res));
            die;
            if($res['return_code']=='success'){
                 $data['uid']=$res['id'];
                if (model('employee')->data($data)->add()) {
                    $this->dexit(array('error'=>0,'msg'=>'添加成功'));
                }else{
                    $this->dexit(array('error'=>1,'msg'=>'添加失败'));
                }
            }else{
                $this->dexit(array('error'=>1,'msg'=>$res['content']));

            }


        }
        $roles = Food_store_role::find()->where(['store_id'=>7])->orderBy('id desc')->all();
        return $this->render('employee_add',['roles'=>$roles]);
    }
}
