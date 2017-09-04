<?php
namespace app\addons\food\publics\controllers;
use Yii;
use yii\web\Controller;
use app\addons\food\models\Food_company;
use app\addons\food\models\Food_employee;
use app\addons\food\models\UploadForm2;
use app\vendor\org\CommonApi;
use yii\web\UploadedFile;
/**
 * Default controller for the `publics` module
 */
class DefaultController extends Controller
{
    //public $enableCsrfValidation = false;
    public function init()
    {
        parent::init();
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    //登录入口
    public function actionIndex()
    {
        echo Yii::$app->request->csrfToken;die;
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
    public function actionValidate_company_name()
    {
        $data=Yii::$app->request->get();
        // $a=Food_company::find()->where('company_name=:name',[':name'=>$data['company_name']])->asArray()->one();
        // $this->dexit(array('valid'=> $a));
        $data1=Food_company::find()->where('company_name=:name',[':name'=>$data['company_name']])->asArray()->one();
        if(isset($data1))
        {
            if($data['type']==1)
            {
                //验证驳回的公司名
                if($data1['company_name']!=$data['company_name'])
                {
                    $this->dexit(array('valid'=>false));
                }else
                {
                    $this->dexit(array('valid'=>true));
                }
            }
            $this->dexit(array('valid'=>false));
        }else
        {
            $this->dexit(array('valid'=>true));
        }
    }
    public function actionEdit_company()
    {
        $model=new UploadForm2();
        $data=Yii::$app->request->get();
        $data1=Food_company::find()->where('id=:cid',[':cid'=>$data['cid']])->asArray()->one();
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            $data2=[];
            $a=$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $a=count($a);
            if($a>0 && $a<3)
            {

                echo "<script>alert('请上传营业执照/身份证正面照/身份证反面照');location.href=history.go(-1);</script>";
                die;
            }
            if($a>0 && $a==3)
            {
                unlink($data1['licence_path']);
                unlink($data1['frontal_view']);
                unlink($data1['back_view']);
                if ($model->upload($post['id'],'company_cert'))
                {
                    // 文件上传成功
                    $post['licence_path']=$model->field_path[0];
                    $post['frontal_view']=$model->field_path[1];
                    $post['back_view']=$model->field_path[2];
                    $post['status']=0;
                    unset($post['_csrf']);
                    unset($post['UploadForm2']);
                    unset($post['repass']);
                    unset($post['code']);
                    $return=Yii::$app->db->createCommand()->update('food_company', $post, 'id = '.$post['id'])->execute();
                    if($return)
                    {
                        echo "<script>alert('重新提交成功');location.href='?r=plugin/publics/default/super_login'</script>";
                        die;
                    }else
                    {
                        echo "<script>alert('重新提交失败，请稍后再试');location.href='?r=plugin/publics/default/super_login';</script>";
                        die;
                    }
                }
               //三张必选

            }elseif($a==0)
            {
               //如果没有只需要更改密码
                unset($post['_csrf']);
                unset($post['UploadForm2']);
                unset($post['repass']);
                unset($post['code']);
                $post['status']=0;
                $return=Yii::$app->db->createCommand()->update('food_company', $post, 'id = '.$post['id'])->execute();
                if($return)
                {
                    echo "<script>alert('修改成功');location.href='?r=plugin/publics/default/super_login';</script>";
                    die;
                }else
                {
                    echo "<script>alert('修改失败，请稍后再试');location.href='?r=plugin/publics/default/super_login';</script>";
                    die;
                }
            }
        }
        return $this->render('edit_company',['data1'=>$data1,'model'=>$model]);
    }
    //商家申请入住
    public function actionCreate_company()
    {
        header("Content-type: text/html; charset=utf-8");
        $model=new UploadForm2();
        if (Yii::$app->request->isPost) {
            //先插入到数据库
            $post=Yii::$app->request->post();
            if(Yii::$app->session['code'] != $post['code']){
                echo "<script>alert('验证码错误');location.href=history.go(-1);</script>";die;
                    
            }
            unset($post['_csrf']);
            unset($post['UploadForm2']);
            unset($post['code']);
            unset($post['repass']);
            $post['addtime']=time();
            $post['password']=md5($post['password']);
            if(Yii::$app->db->createCommand()->insert('food_company',$post)->execute())
            {
                $data=[];
                //获取公司的cid
                $cid=Yii::$app->db->getLastInsertID();
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                if ($model->upload($cid,'company_cert')) {
                // 文件上传成功
                $data['licence_path']=$model->field_path[0];
                $data['frontal_view']=$model->field_path[1];
                $data['back_view']=$model->field_path[2];
                //插入到数据库
                if(Yii::$app->db->createCommand()->update('food_company',$data,'id='.$cid)->execute())
                {
                    echo "<script>alert('创建成功，请耐心等待审核');location.href='?r=plugin/publics/default/super_login'</script>";
                    die;
                }else
                {
                    echo "<script>alert('创建失败，请稍后再试');location.href=history.go(-1);</script>";
                    die;
                }
            }else
            {
                echo 'fail';
            }
        }
    }
    	return $this->render('create_company',['model'=>$model]);
}
    //员工登录
    public function actionShop_login()
    {

         if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $employee = Food_employee::find()->where(['phone'=>$data['phone']])->asArray()->one();
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
    //店铺退出登录
    public function actionShop_out_login()
    {
        $session = \Yii::$app->session;
        if (Yii::$app->session['cid']) {
            $session->remove('employee');
            $session->remove('shop_id');
                header('Location:index.php?r=plugin/stores/homepage/index');die;

            }else{
                $session->remove('employee');
                header('Location:index.php?r=plugin/publics/default/index');die;
            }
    }

    public function actionMessage()
    {
        $tel = Yii::$app->request->get('tel');
        $rand_num = rand(1111,9999);
        $user = new CommonApi();
        $res = $user->message($tel,$rand_num);
        if ($res['return_code'] == 'SUCCESS') {
            $session = Yii::$app->session;
            session_set_cookie_params(3600*24);
            $session['code'] = $res['rand_num'];
           $this->dexit(['error'=>0,'msg'=>'发送成功']);
        }else{
           $this->dexit(['error'=>0,'msg'=>'发送失败']);

        }

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