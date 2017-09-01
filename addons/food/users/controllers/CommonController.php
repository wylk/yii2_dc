<?php
namespace app\addons\food\users\controllers;
use yii\web\Controller;
use Yii;
use app\vendor\org\CommonApi;
class CommonController extends  Controller
{
    public $layout = false;
    public $cid;
    public $mid;
    public $uid=19;
    public $table_id;
    public $eid;
    public function init()
    {
        parent::init();
        header("Content-type: text/html; charset=utf-8");
        $session=Yii::$app->session;
        $session->open();
        $data=Yii::$app->request->get();
        if(isset($data['cid']))
        {
            $this->cid=$data['cid'];
            $session->set('cid',$data['cid']);
            // $this->cid=
        }else
        {
            $this->cid=$session->get('cid');
        }
        if(isset($data['shop_id']))
        {
            $session['employee']=[
            'shop_id'=>$data['shop_id'],

            ];
            $this->mid=$session['employee']['shop_id'];
        }else
        {
            $this->mid=$session['employee']['shop_id'];
        }
        if(isset($data['eid']))
        {
            $session['employee']=[
            'id'=>$data['eid'],

            ];
            $employee=Food_employee::find()->where(['id'=>$data['eid'],'shop_id'=>$data['shop_id']])->asArray()->one();
            $session->set('uid',$employee['uid']);
            $this->uid=$session->get('uid');
            $this->eid=$session['employee']['id'];
        }else
        {
            //员工入口
            if($session->get('uid') && $session['employee']['id'])
            {
                $this->uid = $session->get('uid');
                $this->eid  = $session['employee']['id'];
            }
            if($session['userinfo']){
              $this->uid = $session['userinfo']['uid']=19;
              $this->openid = $session['userinfo']['openid'];
            }
            // $this->uid=$session->get('uid');
        }
        if(isset($data['table_id']))
        {
            $this->table_id=$data['table_id'];
            $session->set('table_id',$data['table_id']);
        }else
        {
            $this->table_id=$session->get('table_id');
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
    public function is_weixin()
    {
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false){
            return true;
        }else{
            return false;
        }
    }
    public function userStatus()
    {
        $boj=new CommonApi;
        $session=Yii::$app->session;
        if(!$this->eid)
        {
            if(!$session->get('userinfo'))
            {
                $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $appid = 'LB06yeov34iw1vs9lo';
                $data=Yii::$app->request->get();
                if(empty($data['userinfo']))
                {
                    if(isset($data['openid']))
                    {
                        $user=$obj->weixLogin(['openid'=>$data['openid']]);
                        $session->set('openid',$data['openid']);
                        if($user)
                        {
                            $session['userinfo']=[
                            'uid'=>$user['uid'],
                            'openid'=>$user['openid'],
                            ];
                        }
                    }else
                    {
                        $oaut_url = 'https://lepay.51ao.com/pay/api/openid.php?appid_api='.$appid.'&redirect='.urlencode($url);
                                header('Location: ' . $oaut_url);exit;
                    }
                }
                if(!$user)
                {
                    if(!$data['userinfo'])
                    {
                        $oaut_url = 'https://lepay.51ao.com/pay/api/openid.php?code=userinfo&appid_api='.$appid.'&redirect='.urlencode($url);
                        header('Location: ' . $oaut_url);exit;
                    }else
                    {
                        $userinfo = json_decode(base64_decode($data['userinfo']), true);
                        if($userinfo['nickname'])
                        {
                            $user=$obj->add_user('','',$userinfo['openid'],$userinfo['nickname'],$userinfo['headimgurl']);
                            if($id>0)
                            {
                                $session['userinfo']=[
                                'uid'=>$id,
                                'openid'=>$userinfo['openid'],
                                ];
                            }
                        }
                    }

                }
            }
        }
    }
}