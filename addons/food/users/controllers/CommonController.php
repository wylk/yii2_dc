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
        $view = Yii::$app->view;
        $view->params['mid'] = $this->mid;
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
    public function do_queue_buyer_time($bl)
    {
        $queues=Food_queue_add_lin::find()->where(['status'=>1])->asArray()->all();
        $tables=Food_shop_tables::find()->where(['status'=>0])->asArray()->all();
        $aa = [];
        if ($tables) {
            foreach ($queues as $key => $vv) {
                $sm = 100000000000;
                $a = [];

                foreach ($tables as $k=> $v) {
                    if ($v['store_id'] == $vv['store_id']) {
                        if ($v['user_count'] >= $vv['limit_num'] ) {
                            $n = abs($v['user_count']-$vv['limit_num']);
                            if ($sm > $n && $n < $bl) {
                                $sm = $n;
                                $a['table'] = $v;
                                $a['queue'] = $vv;
                            }
                        }
                    }
                }
                if (isset($a)) {
                    $aa[]=$a;
                }

            }

        }

        foreach ($aa as $kk => $vv) {
            $table_id = $vv['table']['id'];
            $queue_id = $vv['queue']['id'];
            $buyer=food_queue_buyer::find()->where(['status'=>1,'queue_id'=>$queue_id])->asArray()->one();
            //echo $table_id;
            $data['status'] = 2;
            $data['table_id'] = $table_id;
            if (Yii::$app->db->createCommand()->update('food_queue_buyer',$data,'id='.$buyer['id'])->execute()) {
                Yii::$app->db->createCommand()->update('food_shop_tables',['status'=>1],'id='.$table_id)->execute();
            }


        }

    }
    public function do_good_stock($orderinfo)
    {
        $order_good=Food_order_goods::find()->where(['order_id'=>$orderinfo['id']])->asArray()->all();
        $goods_id = '';
        foreach ($order_good as $key => $v) {
           $goods_id .= $v['goods_id'].',';
        }
        $goods_id = rtrim($goods_id,',');
        $goods=Food_goods::find()->where(['id'=>array('in',$goods_id)])->asArray()->all();
        $today_time = strtotime(date(Ymd));
        foreach ($goods as $key => $vv) {
            $good=Food_goods::find()->where(['id'=>$vv['id']])->asArray()->one();
            if($today_time > $good['goods_today_time']){
                Yii::$app->db->createCommand()->update('food_goods',array('goods_today_stock'=>$good['goods_per_stock'],'goods_today_time'=>time()),'id='.$good['id'])->execute();
                $good=Food_goods::find()->where(['id'=>$vv['id']])->asArray()->one();
            }
            Yii::$app->db->createCommand()->update('food_goods',array('goods_today_stock'=>($good['goods_today_stock']-1)),'id='.$vv['id'])->execute();
        }

        return true;
    }
}