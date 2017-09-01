<?php

namespace app\addons\food\shops\controllers;

use Yii;
use app\addons\food\shops\controllers\CommonController;
use app\addons\food\models\Food_store_auth;
use yii\data\Pagination;
use app\addons\food\models\Food_employee;
use app\addons\food\models\Food_company;
use app\addons\food\models\Food_store_role;
use app\addons\food\models\Food_shop;
use app\addons\food\models\Food_goods;
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
    	$session = Yii::$app->session;
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
<<<<<<< HEAD
        	$authInfoA = Food_store_auth::find()->where(['auth_level'=>0,'is_show'=>1])->asArray()->orderBy('id asc')->all();
        	$authInfoB = Food_store_auth::find()->where(['auth_level'=>1,'is_show'=>1])->asArray()->orderBy('id asc')->all();
            //$authInfoA = model('store_auth')->where(array('auth_level'=>0,'is_show'=>1))->order('id asc')->select();
            //$authInfoB = model('store_auth')->where(array('auth_level'=>1,'is_show'=>1))->order('id asc')->select();
=======
            $cache = Yii::$app->cache; 
            $authInfoA = $cache->get('cache_data_authInfoA'); 
            $authInfoB = $cache->get('cache_data_authInfoB'); 
            if ($authInfoA === false) {
            	$authInfoA = Food_store_auth::find()->where(['auth_level'=>0,'is_show'=>1])->asArray()->orderBy('id asc')->all();
            	$authInfoB = Food_store_auth::find()->where(['auth_level'=>1,'is_show'=>1])->asArray()->orderBy('id asc')->all();
                $cache->set('cache_data_authInfoA', $authInfoA, 60*60); 
                $cache->set('cache_data_authInfoB', $authInfoB, 60*60); 
            }
>>>>>>> ef52423952501591227e18258fbcdceed048d7ac
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
        $shop_id = Yii::$app->session['employee']['shop_id'];
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
            $user = new CommonApi();
            $res = $user->add_user($password,$data['username'],'','','');
            if($res['return_code']=='success'){
                 $data['uid']=$res['id'];
                if (Yii::$app->db->createCommand()->insert('food_employee',$data)->execute()) {
                    $this->dexit(array('error'=>0,'msg'=>'添加成功'));
                }else{
                    $this->dexit(array('error'=>1,'msg'=>'添加失败'));
                }
            }else{
                $this->dexit(array('error'=>1,'msg'=>$res['content']));

            }


        }
        $roles = Food_store_role::find()->where(['store_id'=>Yii::$app->session['employee']['shop_id']])->orderBy('id desc')->all();
        return $this->render('employee_add',['roles'=>$roles]);
    }
    //修改员工
    public function actionDo_employee_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $employee = Food_employee::find()->where(['truename'=>$data['truename']])->andwhere('status <> 2')->andwhere('id <> '.$data['employee_id'])->one();
            if ($employee) {
               $this->dexit(array('error'=>1,'msg'=>'真实姓名也存在'));
            }

            $employee1 = Food_employee::find()->where(['username'=>$data['username']])->andwhere('status <> 2')->andwhere('id <> '.$data['employee_id'])->one();
            if ($employee1) {
               $this->dexit(array('error'=>1,'msg'=>'登录账号也存在'));
            }
            $employee2 = Food_employee::find()->where(['phone'=>$data['phone']])->andwhere('status <> 2')->andwhere('id <> '.$data['employee_id'])->one();
            if ($employee2) {
               $this->dexit(array('error'=>1,'msg'=>'手机号码也存在'));
            }
            $employee3 = Food_employee::find()->where(['email'=>$data['email']])->andwhere('status <> 2')->andwhere('id <> '.$data['employee_id'])->one();
            if ($employee3) {
               $this->dexit(array('error'=>1,'msg'=>'邮箱号码也存在'));
            }
            $id = $data['employee_id'];
            unset($data['employee_id']);
            if ($data['password'] == '') {
              unset($data['password']);
            }else{
              $data['password'] = md5($data['password']);
            }
            
            if (Yii::$app->db->createCommand()->update('food_employee',$data,'id='.$id)->execute()) {
               $this->dexit(array('error'=>0,'msg'=>'修改成功'));
            }else{
                $this->dexit(array('error'=>1,'msg'=>'修改失败'));
            }
        }
        $employee_id = Yii::$app->request->get()['employee_id'];
        $employee = Food_employee::find()->where(['id'=>$employee_id])->one();
        $roles = Food_store_role::find()->where(['store_id'=>Yii::$app->session['employee']['shop_id']])->orderBy('id desc')->all();
        return $this->render('employee_edit',['employee'=>$employee,'roles'=>$roles]);
    }

    //角色管理
    public function actionDo_employee_role()
    {
        $shop_id = Yii::$app->session['employee']['shop_id'];
        $data = Food_store_role::find()->where(['store_id' => $shop_id]);
        $pages = new Pagination(['totalCount' => $data->count(),'pageSize' => '10']);
        $role = $data->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('employee_role',['role'=>$role,'pages'=>$pages]);
    }

    //del角色
    public function actionEmpolyee_role_del()
    {
        $id = Yii::$app->request->get()['id'];
        if (Food_store_role::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }

    }

    //add角色
    public function actionDo_employee_role_add()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $ids = rtrim($data['all_id'],',');
            $datas['store_id'] = Yii::$app->session['employee']['shop_id'];
            $datas['role_name'] = $data['role_name'];
            $datas['role_auth_ids'] = $ids;
            if (Yii::$app->db->createCommand()->insert('food_store_role',$datas)->execute()) {
               $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
               $this->dexit(['error'=>1,'msg'=>'添加失败']);  
            }
        }
        $cache = Yii::$app->cache; 
        $data = $cache->get('cache_data_employee_role_add');
        $auth1 = $data['one']; 
        $auth2 = $data['two']; 
        if ($data === false) {
            $a = array();   
            $auth1 = Food_store_auth::find()->where(['auth_level'=>0])->asArray()->all();
            $auth2 = Food_store_auth::find()->where(['auth_level'=>1])->asArray()->all();
            $a['one'] = $auth1;
            $a['two'] = $auth2;
            $cache->set('cache_data_employee_role_add', $a, 60*60);
        } 
        return $this->render('employee_role_add',['auth1'=>$auth1,'auth2'=>$auth2]);
    }
    //修改角色
    public function actionDo_employee_role_edit()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $ids = rtrim($data['all_id'],',');
            $datas['role_name'] = $data['role_name'];
            $datas['role_auth_ids'] = $ids;
            if(Yii::$app->db->createCommand()->update('food_store_role',$datas,'id='.$data['role_id'])->execute()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }
        }
        $role_id = Yii::$app->request->get()['role_id'];
        $cache = Yii::$app->cache;
        $auth = $cache->get('cache_data_employee_role_add');
        $roles = Food_store_role::find()->where(['id'=>$role_id])->one();
        return $this->render('employee_role_edit',['roles'=>$roles,'auth1'=>$auth['one'],'auth2'=>$auth['two'],]);
    }

    /*$data = Food_store_role::find()->where(['store_id' => $shop_id]);
    $pages = new Pagination(['totalCount' => $data->count(),'pageSize' => '10']);
    $role = $data->offset($pages->offset)->asArray()->limit($pages->limit)->all();*/

    //商品列表
    public function actionDo_goods_list()
    { 
        $session = Yii::$app->session;
        session_set_cookie_params(3600*24);
        if(Yii::$app->request->isPost){
            $search = Yii::$app->request->post()['goods_name'];
            if($search != ''){
                $where = ['goods_name'=>$search]; 
                $datase = $search;
                $session['goods_name'] = $where;
            }else{
                $where = ''; 
                $datase = '全部';
                $session['goods_name'] = '';
            }
            
        }else{
            $where = '';
            $datase = '全部';
            $session['goods_name'] = '';
        }

        if(Yii::$app->request->isGet && $session['goods_name'] != ''){
            $where = $session['goods_name'];
        }
        $datas = Food_goods::find()->where(['shop_id'=>Yii::$app->session['employee']['shop_id']])->andwhere($where);
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('googs_list',['data'=>$data,'pages'=>$pages,'datasearch'=>$datase]);

    }

    public function actionDo_goods_del()
    {
        $id = Yii::$app->request->get()['id'];
        if (Food_goods::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }
}
