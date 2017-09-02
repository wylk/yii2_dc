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
use app\addons\food\models\Food_cat;
use app\addons\food\models\Food_spec;
use app\addons\food\models\Food_shop_tablezones;
use app\addons\food\models\Food_shop_tables;
use app\addons\food\models\Food_shop_print_label;
use app\addons\food\models\Food_queue_add_lin;
use app\addons\food\models\Food_queue_buyer;
use app\addons\food\models\Food_order;
use app\addons\food\models\Food_order_goods;
use app\vendor\org\CommonApi;
use app\addons\food\models\UploadForm;
use yii\web\UploadedFile;
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
        $cache = Yii::$app->cache; 
    	$this->layout = 'layout2';
        if (isset(Yii::$app->session['cid']) || Yii::$app->session['employee']['role_id'] == 0) {
            $authInfoA = $cache->get('cache_data_authInfoA'); 
            $authInfoB = $cache->get('cache_data_authInfoB'); 
            if ($authInfoA === false) {
            	$authInfoA = Food_store_auth::find()->where(['auth_level'=>0,'is_show'=>1])->asArray()->orderBy('id asc')->all();
            	$authInfoB = Food_store_auth::find()->where(['auth_level'=>1,'is_show'=>1])->asArray()->orderBy('id asc')->all();
                $cache->set('cache_data_authInfoA', $authInfoA, 60*600000); 
                $cache->set('cache_data_authInfoB', $authInfoB, 60*600000); 
            }

        }else{
            $role_id = Yii::$app->session['employee']['role_id'];
            $authInfoA = $cache->get('cache_data_authInfoA'.$role_id );
            $authInfoB = $cache->get('cache_data_authInfoB'.$role_id );
            if($authInfoA == false){
                $role  = Food_store_role::find()->where(['store_id'=>$this->mid,'id'=>$role_id ])->asArray()->one();
                $authInfo = [];
                $authInfoA = Food_store_auth::find()->where(['auth_level'=>0,'is_show'=>1])->andwhere('id in('.$role['role_auth_ids'].')')->asArray()->orderBy('id asc')->all();
                $authInfoB = Food_store_auth::find()->where(['auth_level'=>1,'is_show'=>1])->andwhere('id in('.$role['role_auth_ids'].')')->asArray()->orderBy('id asc')->all();
                $cache->set('cache_data_authInfoA'.$role_id, $authInfoA, 60*600000); 
                $cache->set('cache_data_authInfoB'.$role_id, $authInfoB, 60*600000); 
            }
        }
       	return $this->render('left_menu',['authInfoA'=>$authInfoA,'authInfoB'=>$authInfoB,'action'=>$data['action']]);
    }
    //员工列表
    public function actionDo_employee_list()
    {
        $shop_id = $this->mid;
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
            $shop = Food_shop::find()->where(['id'=>$this->mid])->asArray()->one();

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
        $roles = Food_store_role::find()->where(['store_id'=>$this->mid])->orderBy('id desc')->all();
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
        $roles = Food_store_role::find()->where(['store_id'=>$this->mid])->orderBy('id desc')->all();
        return $this->render('employee_edit',['employee'=>$employee,'roles'=>$roles]);
    }

    //角色管理
    public function actionDo_employee_role()
    {
        $shop_id = $this->mid;
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
            $auths = Food_store_auth::find()->select('auth_a,auth_c')->where('id in('.$ids.')')->asArray()->all();
            $ac = '';
            foreach ($auths as  $v) {
               $ac.=$v['auth_a'].'-'.$v['auth_c'].',';
            }

            $datas['store_id'] = $this->mid;
            $datas['role_name'] = $data['role_name'];
            $datas['role_auth_ids'] = $ids;
            $datas['role_auth_ac'] =  $ac;
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

            $auths = Food_store_auth::find()->select('auth_a,auth_c')->where('id in('.$ids.')')->asArray()->all();
            $ac = '';
            foreach ($auths as  $v) {
               $ac.=$v['auth_a'].'-'.$v['auth_c'].',';
            }

            $datas['role_name'] = $data['role_name'];
            $datas['role_auth_ids'] = $ids;
             $datas['role_auth_ac'] =  $ac;
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
        $datas = Food_goods::find()->where(['shop_id'=>$this->mid])->andwhere($where);
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('googs_list',['data'=>$data,'pages'=>$pages,'datasearch'=>$datase]);

    }
    //删除商品
    public function actionDo_goods_del()
    {
        $id = Yii::$app->request->get()['id'];
        if (Food_goods::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //添加商品
    public function actionDo_goods_add()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->goodsUpload($this->mid,'shop_goods')){
                $goods_img = $model->file_path;
                unset($data['UploadForm']);
            }
            $data['goods_img'] = $goods_img;
            $data['suppy_time']=implode(',',$data['suppy_time']);
            $data['shop_id']=$this->mid;
            $data['addtime']=time();
            $data['goods_today_time'] = time();
            if (Yii::$app->db->createCommand()->insert('food_goods',$data)->execute()) {
                echo "<script>alert('添加成功');window.location.href='?r=plugin/shops/index/do_goods_list';</script>";
            }else{
                echo "<script>alert('添加失败，请稍后再试');history.go(-1);</script>";
            }
            die;
        }
        $data = Food_cat::find()->where(['shop_id'=>$this->mid])->asArray()->all();
        $data=$this->GetTree($data,0,0);
        $data1 = Food_spec::find()->where(['shop_id'=>$this->mid])->asArray()->orderBy('sort desc')->all();
        return $this->render('goods_add',['data'=>$data,'data1'=>$data1,'model'=>$model]);

    }

    public function GetTree($arr,$pid,$step){
        global $tree;
        foreach($arr as $key=>$val) {
              if($val['pid'] == $pid) {
                  $flg = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-----',$step);
                  $val['name'] = $flg.$val['cat_name'];
                  $tree[] = $val;
                  $this->GetTree($arr , $val['id'] ,$step+1);
              }
          }
          return $tree;
    }

    //修改商品
    public function actionDo_goods_edit()
    {
        $model = new UploadForm();
         if (Yii::$app->request->isPost) {
           $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $id = $data['cid'];
            $goods = Food_goods::find()->where(['id'=>$id])->asArray()->one();
            unset($data['cid']);
            if (is_readable($goods['goods_img']) == true) { 
                unlink($goods['goods_img']);
            } 
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->goodsUpload($this->mid,'shop_goods')){
                $goods_img = $model->file_path;
                unset($data['UploadForm']);
            }
            $data['goods_img'] = $goods_img;
            $data['suppy_time']=implode(',',$data['suppy_time']);
            if (Yii::$app->db->createCommand()->update('food_goods',$data,'id='.$id)->execute()) {
                echo "<script>alert('修改成功');window.location.href='?r=plugin/shops/index/do_goods_list';</script>";
            }else{
                echo "<script>alert('修改失败，请稍后再试');history.go(-1);</script>";
            }
            die;
        }
        $data = Yii::$app->request->get()['cid'];
        $data1 = Food_goods::find()->where(['id'=>$data])->one();
        $data2 = Food_cat::find()->where(['shop_id'=>$this->mid])->asArray()->all();
        $data2 = $this->GetTree($data2,0,0);
        $data3 = Food_spec::find()->where(['shop_id'=>$this->mid])->asArray()->orderBy('sort desc')->all();
        return $this->render('goods_edit',['data'=>$data,'data1'=>$data1,'data2'=>$data2,'data3'=>$data3,'model'=>$model]);
    }

    //商品分类列表
    public function actionDo_goods_cat()
    {
        $datas = Food_cat::find()->where(['shop_id'=>$this->mid]);
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        $data1= Food_cat::find()->where(['shop_id'=>$this->mid,'pid'=>0])->all();
        $data3['cat_name'] = '全部';
        return $this->render('good_cat',['data'=>$data,'data1'=>$data1,'pages'=>$pages,'data3'=>$data3]);
    }

    //删除商品分类
    public function actionDo_cat_del()
    {
        $id = Yii::$app->request->get()['del_id'];
        if (Food_cat::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }

    }

    //添加商品分类
    public function actionDo_cat_add()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $data['shop_id'] = $this->mid;
            $data['addtime'] = time();
            unset($data['_csrf']);
            if (Yii::$app->db->createCommand()->insert('food_cat',$data)->execute()) {
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'添加失败']);

            }
        }
        $data = Food_cat::find()->where(['shop_id'=>$this->mid,'pid'=>0])->asArray()->all();
        return $this->render('cat_add',['data'=>$data]);
    }

    //修改商品分类
    public function actionDo_cat_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $id = $data['cid'];
            unset($data['cid']);
            unset($data['_csrf']);
            if (Yii::$app->db->createCommand()->update('food_cat',$data,'id='.$id)->execute()) {
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'修改失败']);

            }
        }
        $id = Yii::$app->request->get()['cid'];
        $data1 = Food_cat::find()->where(['id'=>$id])->asArray()->one();
        $data2 = Food_cat::find()->where(['shop_id'=>$this->mid,'pid'=>0])->asArray()->all();
        return $this->render('cat_edit',['data1'=>$data1,'data2'=>$data2]);
    }

    //商品规格
    public function actionDo_goods_spec()
    {
        $datas = Food_spec::find()->where(['shop_id'=>$this->mid]);
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
       
        $data2['spec_name'] = '全部';
        return $this->render('goods_spec',['data'=>$data,'data2'=>$data2,'pages'=>$pages]);
    }

    //商品规格删除
    public function actionDo_spec_del()
    {
        $id = Yii::$app->request->get()['del_id'];
        if (Food_spec::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }

    }

    //添加商品规格
    public function actionDo_goods_spec_add()
    {
        if (Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $data['shop_id']=$this->mid;
            $data['addtime']=time();
            $datas = [];
            foreach ($data['spec_value'] as $key => $value) {
                foreach ($data['proportion'] as $k => $v) {
                    if ($key == $k) {
                        $datas[] = array('id'=>$key,'spec_name'=>$value,'proportion'=>$v);
                    }
                }
            }
            $data['spec_value'] = json_encode($datas);
            unset($data['proportion']);
            if (Yii::$app->db->createCommand()->insert('food_spec',$data)->execute()) {
                echo "<script>alert('修改成功');window.location.href='?r=plugin/shops/index/do_goods_spec';</script>";
            }else{
                echo "<script>alert('修改失败，请稍后再试');history.go(-1);</script>";
            }
            die;
        }
        return $this->render('spec_add');
    }
     //修改商品规格
    public function actionDo_goods_spec_edit()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $datas = [];
            foreach ($data['spec_value'] as $key => $value) {
                foreach ($data['proportion'] as $k => $v) {
                    if ($key == $k) {
                        $datas[] = array('id'=>$key,'spec_name'=>$value,'proportion'=>$v);
                    }
                }
            }
            $data['spec_value'] = json_encode($datas);
            unset($data['proportion']);
            $id = $data['cid'];
            unset($data['cid']);
            if (Yii::$app->db->createCommand()->update('food_spec',$data,'id='.$id)->execute()) {
                echo "<script>alert('修改成功');window.location.href='?r=plugin/shops/index/do_goods_spec';</script>";
            }else{
                echo "<script>alert('修改失败，请稍后再试');history.go(-1);</script>";
            }
            die;
            var_dump($data);die;
        }
        $id = Yii::$app->request->get()['cid'];
        $data1 = Food_spec::find()->where(['id'=>$id])->asArray()->one();
        return $this->render('spec_edit',['data1'=>$data1]);

    }

    /*
        Food_shop_tablezones;
        Food_shop_tables;
        Food_shop_print_label
    */

    //餐桌管理
    public function actionDo_shop_table()
    {
        $datas = Yii::$app->db->createCommand('select a.*,b.title as b_title,c.title as c_title  from food_shop_tables as a Left Join food_shop_tablezones as b on a.tablezonesid=b.id Left Join food_shop_print_label as c on a.table_label_id=c.id where a.store_id='.$this->mid.' order by displayorder asc')->queryAll();
        return $this->render('shop_table',['datas'=>$datas]);
    }

    //餐桌状态修改

    public function actionTable_status()
    {
        $data = Yii::$app->request->post();
        unset($data['_csrf']);
        $table = Food_shop_tables::findOne($data['table_id']);
        $table->status = $data['status'];
        if ($table->save()) {
            $this->dexit(['error'=>0,'msg'=>'修改成功']);   
        }else{
            $this->dexit(['error'=>1,'msg'=>'修改失败']); 
        }
    }
    //一键清台
    public function actionTable_allstatus()
    {
        $data = Yii::$app->request->get('ids');
        if($data == 'all'){
            $count = Food_shop_tables::updateAll(['status'=>0],'store_id=:st',array(':st'=>$this->mid)); 
            if($count){
                $this->dexit(['error'=>0,'msg'=>'清台成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'清台失败']); 
            }
        }

    }

    //删除餐桌
    public function actionShop_table_del()
    {
        $id = Yii::$app->request->get('id');
        if(Food_shop_tables::findOne($id)->delete()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);

        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //餐桌二维码
    public function actionDo_shop_table_qrcode()
    {
        $sql = 'select a.*,b.title as b_title,c.title as c_title  from food_shop_tables as a Left Join food_shop_tablezones as b on a.tablezonesid=b.id Left Join food_shop_print_label as c on a.table_label_id=c.id where a.store_id='.$this->mid.' order by displayorder asc';
        $datas = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('shop_table_qrcode',['datas'=>$datas]);
    }

    //添加餐桌
    public function actionDo_shop_table_add()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $data['store_id'] = $this->mid;
            $data['dateline'] = time();
            if(Yii::$app->db->createCommand()->insert('food_shop_tables',$data)->execute()){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']); 
            }
        }
        $datas = Food_shop_tablezones::find()->select('id,title')->where(['status'=>1,'store_id'=>$this->mid])->asArray()->orderBy('displayorder asc')->all();
        $printlabel = Food_shop_print_label::find()->select('id,title')->where(['status'=>1,'store_id'=>$this->mid])->asArray()->orderBy('displayorder asc')->all();
        return $this->render('shop_table_add',['datas'=>$datas,'printlabel'=>$printlabel]);
    }

    //餐桌详情
    public function actionDo_shop_table_info()
    {
        $id = Yii::$app->request->get('table_id');
        $sql = 'select a.*,b.title as b_title,c.title as c_title  from food_shop_tables as a Left Join food_shop_tablezones as b on a.tablezonesid=b.id Left Join food_shop_print_label as c on a.table_label_id=c.id where a.id='.$id.' and a.store_id='.$this->mid;
        $datas = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('shop_table_info',['datas'=>$datas]);
    }

    //餐桌修改
    public function actionDo_shop_table_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $id = $data['table_id'];
            unset($data['_csrf'],$data['table_id']);
            if(Yii::$app->db->createCommand()->update('food_shop_tables',$data,'id='.$id)->execute()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{  
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }
        $id = Yii::$app->request->get('table_id');
        $data = Food_shop_tables::find()->where(['id'=>$id])->asArray()->one();
        $datas = Food_shop_tablezones::find()->select('id,title')->where(['status'=>1,'store_id'=>$this->mid])->asArray()->orderBy('displayorder asc')->all();
        $printlabel = Food_shop_print_label::find()->select('id,title')->where(['status'=>1,'store_id'=>$this->mid])->asArray()->orderBy('displayorder asc')->all();
        return $this->render('shop_table_edit',['data'=>$data,'datas'=>$datas,'printlabel'=>$printlabel]);
    }

    //餐桌类型
    public function actionDo_shop_table_type()
    {
        $datas = Food_shop_tablezones::find()->where(['status'=>1,'store_id'=>$this->mid])->asArray()->orderBy('displayorder asc')->all();
        return $this->render('shop_table_type',['datas'=>$datas]);
    }

    //餐桌类型排序
    public function actionTable_type_sort()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $ids = explode(',',rtrim($data['table_id'],','));
            $vs = explode(',',rtrim($data['orders'],','));
            $status = [];
            foreach ($ids as $k => $v) {
                foreach ($vs as $key => $value) {
                    if ($k == $key) {
                        $type = '';
                        $type = Food_shop_tablezones::findOne($v);
                        $type->displayorder = $value;
                        $status[] = $type->save();
                    }
               }
            }

            if ($status == true) {
                $this->dexit(['error'=>0,'msg'=>'排序成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'排序失败']);
            }
        }

    }

    //删除餐桌类型
    public function actionTable_type_del()
    {
        $id = Yii::$app->request->get('id');
        if(Food_shop_tablezones::findOne($id)->delete()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);

        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }

    }
    //添加餐桌类型
    public function actionDo_shop_table_type_add()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $data['store_id'] = $this->mid;
            unset($data['_csrf']);
            if(Yii::$app->db->createCommand()->insert('food_shop_tablezones',$data)->execute()){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{    
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        return $this->render('shop_table_type_add');
    }

    //修改餐桌类型
    public function actionDo_shop_table_type_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $id = $data['type_id'];
            unset($data['_csrf'],$data['type_id']);
            if(Yii::$app->db->createCommand()->update('food_shop_tablezones',$data,'id='.$id)->execute()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
                           
        }
        $id = Yii::$app->request->get('type_id');
        $datas = Food_shop_tablezones::findOne($id);
        return $this->render('shop_table_type_edit',['datas'=>$datas]);
    }

    //添加餐桌标签
    public function actionDo_shop_table_printlabel_add()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $data['store_id'] = $this->mid;
            if(Yii::$app->db->createCommand()->insert('food_shop_print_label',$data)->execute()){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'添加失败']);

            }
        }
        return $this->render('shop_table_printlabel_add');
    }

    //排队管理
    public function actionDo_shop_queue()
    {
        $datas = Food_queue_add_lin::find()->where(['store_id'=>$this->mid])->asArray()->all();
        return $this->render('shop_queue',['datas'=>$datas]);

    }

    //列队管理
    public function actionDo_shop_queue_buyer()
    {
        $datas = Food_queue_add_lin::find()->where(['store_id'=>$this->mid,'status'=>1])->asArray()->all();
        foreach ($datas as $key => &$v) {
            $v['num'] = Food_queue_buyer::find()->where(['queue_id'=>$v['id'],'status'=>1])->count();
        }
        return $this->render('shop_queue_buyer',['datas'=>$datas]);
    }

    //新建列队设置
    public function actionDo_shop_queue_add()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            $data['store_id'] = $this->mid;
            if(Yii::$app->db->createCommand()->insert('food_queue_add_lin',$data)->execute()){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        return $this->render('shop_queue_add');
    }

    //排队列队修改
    public function actionDo_shop_queue_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $id = $data['edit_id'];
            unset($data['_csrf'],$data['edit_id']);
            if(Yii::$app->db->createCommand()->update('food_queue_add_lin',$data,'id='.$id)->execute()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }
        $id = Yii::$app->request->get('edit_id');
        $data = Food_queue_add_lin::find()->where(['store_id'=>$this->mid,'id'=>$id])->one();
        return $this->render('shop_queue_edit',['data'=>$data]);
    }

    //排队列队删除
    public function actionShop_queue_del()
    {
        $id = Yii::$app->request->get('del_id');
        if (Food_queue_add_lin::findOne($id)->delete()) {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{ 
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //大厅二维码
    public function actionDo_hall_qrcode()
    {
        return $this->render('hall_qrcode');

    }

    //未付款订单管理

    public function actionDo_order_unpay()
    {
        $datas = Food_order::find()->select('food_order.*,food_shop_tables.title')->leftJoin('food_shop_tables','food_order.table_id=food_shop_tables.id')->where('food_order.shop_id='.$this->mid.' and food_order.status between 1 and 1');
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('order_unpay',['data'=>$data,'pages'=>$pages]);
    }

    //付款订单
    public function actionDo_order_paid()
    {
        $datas = Food_order::find()->select('food_order.*,food_shop_tables.title')->leftJoin('food_shop_tables','food_order.table_id=food_shop_tables.id')->where('food_order.shop_id='.$this->mid.' and food_order.status=2');
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('order_unpay',['data'=>$data,'pages'=>$pages]);
    }

    //外卖订单
    public function actionDo_order_out_food()
    {
      $datas = Food_order::find()->select('food_order.*,food_shop_tables.title')->leftJoin('food_shop_tables','food_order.table_id=food_shop_tables.id')->where('food_order.shop_id='.$this->mid.' and food_order.status=2 and food_order.eat_type=2');
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $data = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('order_unpay',['data'=>$data,'pages'=>$pages]);

    }

    //订单详情
    public function actionDo_order_edit()
    {
        $order_id = Yii::$app->request->get('order_id');
        $data2 = Food_order::find()->where(['id'=>$order_id])->one();
        $sql = 'select a.*,b.goods_name,b.goods_img,c.cook from food_order_goods as a left join food_goods as b on a.goods_id=b.id left join food_goods as c on c.id=a.goods_id where order_id='.$order_id;
        $data1 = Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render('order_edit',['data1'=>$data1,'data2'=>$data2]);
    }

    //员工入口管理
    public function actionDo_ntrance()
    {
        $datas = Food_store_role::find()->where(['store_id'=>$this->mid]);
        $pages = new Pagination(['totalCount' => $datas->count(),'pageSize' => '10']);
        $role = $datas->offset($pages->offset)->asArray()->limit($pages->limit)->all();
        return $this->render('ntrance',['role'=>$role,'pages'=>$pages]);
    }

    //编辑员工入口权限
    public function actionEdit_ntrance_cat_id()
    {

        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $role = Food_store_role::find()->where(['id'=>$data['role_id']])->one();
            $role->cat_id = $data['cat_id'];
            if($role->save()){
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>0,'msg'=>'修改失败']);
            }
        }
        $id = Yii::$app->request->get('role_id');
        $cat_auth = Food_store_role::find()->select('cat_id')->asArray()->where(['id'=>$id])->one();
        $cat_auth=explode(',',$cat_auth['cat_id']);
        $data = Food_cat::find()->where(['shop_id'=>$this->mid])->all();
        return $this->render('edit_cat_id',['cat_auth'=>$cat_auth,'data'=>$data,'role_id'=>$id]);
    }

    //c厨师入口
    public function actionDo_entrance_cook()
    {
        $role_id = Yii::$app->session['employee']['role_id'];

        if($role_id > 0){
             $cat_id = explode(',',Food_store_role::find()->select('cat_id')->where(['id'=>$id])->one());
        }else{
            $cat_id_all = Food_cat::find()->select('id')->where(['shop_id'=>$this->mid])->all();
            $cid_all = $this->arr2_arr1($cat_id_all,'id');
        }
        $data1 = Food_order::find()->where(['status'=>2,'shop_id'=>$this->mid])->andwhere('print_status in(0,1,2)')->asArray()->all();
        
        foreach($data1 as $v)
        {
          $sql = 'select a.*,b.goods_name,b.cat_id,b.goods_img,b.cook from food_order_goods as a  left join food_goods as b on a.goods_id=b.id where a.order_id='.$v['id'];
          $data1['test'][] = Yii::$app->db->createCommand($sql)->queryAll();
        }
        $data2=[];
        if(Yii::$app->session['cid'] || Yii::$app->session['employee']['role_id'] == 0){
            //店长或经理登录
          foreach($data1['test'] as $v)
          {
              foreach($v  as $k => $v1)
              {
                  if(in_array($v1['cat_id'],$cid_all))
                  {
                      $data2[]=array('goods_id'=>$v1['goods_id'],'goods_num'=>$v1['goods_num'],'goods_name'=>$v1['goods_name'],'goods_img'=>$v1['goods_img'],'order_id'=>$v1['order_id'],'id'=>$v1['id'],'status'=>$v1['status'],'cook'=>$v1['cook']);
                  }
              }
          }
        }elseif(Yii::$app->session['employee']['role_id']!=0 && empty(Yii::$app->session['cid'])) {
       
            //员工登陆
          foreach($data1['test'] as $v)
          {
              foreach($v  as $k => $v1)
              {
                  if(in_array($v1['cat_id'],$cat_id))
                  {
                      $data2[]=array('goods_id'=>$v1['goods_id'],'goods_num'=>$v1['goods_num'],'goods_name'=>$v1['goods_name'],'goods_img'=>$v1['goods_img'],'order_id'=>$v1['order_id'],'id'=>$v1['id'],'status'=>$v1['status'],'cook'=>$v1['cook']);
                  }
              }
          }
        }
        if(Yii::$app->request->isGet){
            $page = Yii::$app->request->get('page');
        }else{
            $page =  1;
        }
        ;
        $data2 = $this->page_array(3,$page,$data2);
        $pagebar=$this->show_array(Yii::$app->session['countpage'],'?r=plugin/shops/index/do_entrance_cook');
        return $this->render('entrance_cook',['data2'=>$data2,'pagebar'=>$pagebar]);
    }

    public  function page_array($count,$page,$array,$order=0)
    {
        global $countpage; #定全局变量
        $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面
            $start=($page-1)*$count; #计算每次分页的开始位置
        if($order == 1){
           $array=array_reverse($array);
        }
        $totals=count($array);
        $countpage=ceil($totals/$count); #计算总页面数
        Yii::$app->session['countpage']=$countpage;
        $pagedata=array();
        $pagedata=array_slice($array,$start,$count);
        return $pagedata; #返回查询数据
    }
    /**
     * 分页及显示函数
     * $countpage 全局变量，照写
     * $url 当前url
     */
    public function show_array($countpage,$url){
        $page=empty($_GET['page'])?1:$_GET['page'];
         if($page > 1){
           $uppage=$page-1;
         }else{
          $uppage=1;
         }
         if($page < $countpage){
           $nextpage=$page+1;
         }else{
           $nextpage=$countpage;
         }
            $str='<div style="border:1px; width:300px; height:30px; color:#9999CC">';
         $str.="<span>共 {$countpage} 页 / 第 {$page} 页</span>";
         $str.="<span><a href='$url&page=1'>  首页 </a></span>";
         $str.="<span><a href='$url&page={$uppage}'> 上一页 </a></span>";
         $str.="<span><a href='$url&page={$nextpage}'>下一页 </a></span>";
         $str.="<span><a href='$url&page={$countpage}'>尾页 </a></span>";
         $str.='</div>';
         return $str;
    }
    //接单
    public function actionReceive()
    {
        if (Yii::$app->request->isPost) {
            $data = $id = Yii::$app->request->post();
            $data1 = Food_order_goods::findOne($data['eid']);
            $data1->status = 1;
            $status = $data1->save();
            $data2 = Food_order::findOne($data['order_id']);
            $data2->status = 2;
            $data2->save();
            if($data1){
                $this->dexit(array('error'=>0,'msg'=>'接单成功'));
            }else {
                $this->dexit(array('error'=>1,'msg'=>'接单失败，请稍后再试'));
            }  
        }
    }

    //出单
    public function actionDo_send_goods()
    {
        if (Yii::$app->request->isPost) {
            $data = $id = Yii::$app->request->post();
            $data1 = Yii::$app->db->createCommand()->update('food_order_goods',['status'=>2],'id='.$data['eid'])->execute();
            $data2 = Food_order::find()->where(['id'=>$data['order_id']])->one();        
            //订单表状态改为已接单
            if($data1){
                if($data2['goods_num']==1){
                    //更改订单表状态
                    $data1 = Yii::$app->db->createCommand()->update('food_order',['print_status'=>3],'id='.$data['order_id'])->execute();
                }else{
                    //商品数量大于2时，循环遍历所有的商品订单表 状态全部为2的更改订单表
                    $data3 = Food_order_goods::find()->where(['order_id'=>$data['order_id'],'status'=>2])->count();
                    if($data3==$data2['goods_num']){
                      //更改订单表状态
                        $data2 = Yii::$app->db->createCommand()->update('food_order',['print_status'=>3],'id='.$data['order_id'])->execute();
                    }
                }
            }
            if($data1){
                $this->dexit(array('error'=>0,'msg'=>'接单成功'));
            }else {
                $this->dexit(array('error'=>1,'msg'=>'接单失败，请稍后再试'));
            }  
        }

    }

    //服务员入口
    public function actionDo_entrance_waiter()
    {
        $this->layout = 'layout3';

        $data1 = Food_shop_tables::find()->where(['status'=>0,'store_id'=>$this->mid])->asArray()->all();
        return $this->render('choose_table_wap',['data1'=>$data1,'mid'=>$this->mid]);
    }

    //预定管理
    public function actionDo_shop_reserve()
    {

        return $this->render('shop_reserve');

    }

}
