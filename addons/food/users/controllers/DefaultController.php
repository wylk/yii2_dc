<?php

namespace app\addons\food\users\controllers;
use yii\web\Controller;
use Yii;
use app\addons\food\models\Food_payment;
use app\vendor\org\CommonApi;
use app\addons\food\models\Food_shop_tables;
use app\addons\food\models\Food_employee;
use app\addons\food\models\Food_cat;
use app\addons\food\users\controllers\CommonController;
use app\addons\food\models\Food_shop;
use app\addons\food\models\Food_cart;
use app\addons\food\models\Food_shop_tablezones;
use app\addons\food\models\Food_order;
use app\addons\food\models\Food_user_address;
use app\addons\food\models\Food_queue_buyer;
use app\addons\food\models\Test;
/**
 * Default controller for the `users` module
 $user = new CommonApi($apiarr);
 $user->getinfo()
 */
class DefaultController extends CommonController
{
    public function actionTest()
    {
        $session=Yii::$app->session;
        echo $session['employee']['shop_id'];
        // $num=Test::findOne(['score'=>101]);
        // echo $num->age;
    }
    public function actionWap_ordermeal()
    {
        $this->layout="layout2";
        return $this->render('wap_ordermeal',['mid'=>$this->mid,'table_id'=>$this->table_id]);
    }
    public function actionWeixin_auto()
    {
        //微信自助付款回调
        $xml = file_get_contents('php://input');
        file_put_contents('./424234234.txt', $xml);
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if($array_data['return_code']=='SUCCESS')
        {
            //更改付款状态为2
            Yii::$app->db->createCommand()->update('food_order',$array_data,'order_no='.$array_data['order_no']);
        }
    }
    public function actionWeixin_qrcode()
    {
        $xml = file_get_contents('php://input');
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $sign=$array_data['sign'];
        unset($array_data['sign']);
        ksort($array_data);
        $string='';
        foreach($array_data as $k=>$v)
        {
            $string.="$k=$v&";
        }
         //获取到appsecret
        $config=Food_payment::findOne(['appid'=>$array_data['appid']]);
        $appsecret=$config->appsecret;
        $string.='key='.$appsecret;
        $newsign = strtoupper(md5($string));
        echo $sign;
        echo '<hr>';
        echo $newsign;
        if ($sign != $newsign) {
            exit('签名错误');
        }else
        {
            if ($array_data['return_code'] == 'SUCCESS')
            {
                $result=Yii::$app->createCommand()->update('food_order',array('trade_no'=>$array_data['transaction_id'],'status'=>2,'paid_time'=>time()),'order_no='.$array_data['out_trade_no'])->execute();
                $orderinfo=Food_order::find()->where(['order_no'=>$array_data['out_trade_no']])->asArray()->one();
                if($orderinfo['eat_type'] == 1){
                    $tableinfo=Yii::$app->db->createCommand()->update('food_shop_tables',array('status'=>3),'id='.$orderinfo['table_id'])->execute();
                }
                $this->do_good_stock($orderinfo);
                //桌号状态改变
                // $orderinfo=model('food_order')->where(array('table_id'=>$array_data['out_trade_no']))->find();

                // $tableinfo=model('food_shop_tables')->data(array('status'=>3))->where(array('id'=>$orderinfo['table_id']))->save();

                if($result && $tableinfo)
                {
                    file_put_contents('./2.txt','success');
                }


            }else
            {
                die('error');
            }
        }
    }
    public function actionPaystatus()
    {
        $data=Yii::$app->request->get();
        $order=Food_order::findOne($data['oid']);
        $paystatus=$order->status;
        if($paystatus)
        {
            $this->dexit(array('msg'=>$paystatus));
        }
    }
    public function actionDo_queue_buyer_times()
    {
        //排队定时任务
        $bl = 2;
        $this->do_queue_buyer_time($bl);

        for ($i=0; $i < 3; $i++) {
            $table=Food_shop_tables::find()->where(['status'=>0])->asArray()->all();
            if ($table) {
                $this->do_queue_buyer_time($bl+1+$i);
            }
        }
    }
    public function actionDo_queue_buyer()
    {
        // if ($this->is_weixin()) {
        //     $this->userStatus();
        // }
        $return=Yii::$app->request->get();
        if(Yii::$app->request->isPost)
        {
            $data=Yii::$app->request->post();
            $status=Food_queue_buyer::find()->where(['u_id'=>$this->uid,'status'=>1,'store_id'=>$this->mid])->asArray()->one();
            if($status)
            {
                $this->dexit(['error'=>1,'msg'=>'你已经排号成功了，不可再排号，取消可重新排号。。']);
            }
            $datas=Food_queue_add_lin::find()->where(['store_id'=>$this->mid,'status'=>1])->orderBy('displayorder asc')->asArray()->all();
            $a = 100000000000;
            $id = 0;
            foreach ($datas as $v) {
                if ($data['buyer_num'] >=  $v['limit_num']) {
                    $b = abs($v['limit_num']-$data['buyer_num']);
                    if ($a > $b) {
                        $a  = $b;
                        $id = $v[id];
                    }

                }
            }
            $data['queue_id'] = $id;
            $data['add_time'] = time();
            $todey = strtotime(date('Ymd'));
            $buyer=Food_queue_buyer::find()->where(['status'=>1,'add_time'=>array('gt',$todey)])->orderBy('buyer_id desc')->asArray()->all();
            if ($buyer) {
               $data['buyer_id'] = $buyer[0]['buyer_id']+1;
            }else{
                $data['buyer_id'] = 10001;
            }
            if(Yii::$app->db->createCommand()->insert('food_queue_buyer',$data)->execute())
            {
                $this->dexit(array('error'=>0,'msg'=>'你已经排号成功。。'));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'你排号失败。。'));
            }
        }
        return $this->render('queue_buyer');
    }
    public function actionDo_queue_buyer_show()
    {
        //显示排队的位置
        $buyer=Food_queue_buyer::find()->where(['u_id'=>$this->uid])->asArray()->one();
        $tables=Food_shop_tables::findOne($buyer['table_id']);
        $shop_tables=$tables->title;
        $queue=Food_queue_add_lin::find()->where(['id'=>$buyer['queue_id']])->asArray()->one();
        $buyers=Food_queue_buyer::find()->where(['queue_id'=>$buyer['queue_id'],'status'=>1])->orderBy('add_time asc')->limit(0,$queue['notify_number'])->asArray()->all();
        $num=Food_queue_buyer::find()->where(array('add_time'=>array('lt',$buyer['add_time'])))->asArray()->count();
        return $this->render('queue_buyer_show',['num'=>$num,'buyers'=>$buyers,'buyer'=>$buyer,'shop_tables'=>$shop_tables]);
    }
    public function actionEdit_address()
    {
        if(Yii::$app->request->isPost)
        {
            $data3=Yii::$app->request->post();
            unset($data3['_csrf']);
            if(Yii::$app->db->createCommand()->update('food_user_address',$data3,'id='.$data3['id'])->execute())
            {
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else
            {
                $this->dexit(['error'=>1,'msg'=>'修改失败，请稍后再试']);
            }
        }
        $data=Yii::$app->request->get();
        $data1=food_user_address::find()->where('id=:address_id',[':address_id'=>$data['aid']])->asArray()->one();
        $this->layout="layout1";
        return $this->render('edit_address',['data1'=>$data1]);
    }
    public function actionDel_address()
    {
        if(Yii::$app->request->isPost)
        {
            $data=Yii::$app->request->post();
            $return=food_user_address::findOne($data['aid']);
            if($return->delete())
            {
                $this->dexit(['error'=>0,'msg'=>'删除成功']);
            }else
            {
                $this->dexit(['error'=>1,'删除失败，请稍后再试']);
            }
        }
    }
    public function actionEdit_default()
    {
        $data=Yii::$app->request->get();
        $return=Yii::$app->db->createCommand()->update('food_user_address',['is_default'=>0],'uid='.$this->uid)->execute();
        if($return)
        {
            $return1=Yii::$app->db->createCommand()->update('food_user_address',['is_default'=>1],'id='.$data['aid'])->execute();
            if($return1)
            {
                echo "<script>alert('应用新地址成功');location.href='?r=plugin/users/default/address_list';</script>";
                die;
            }else
            {
                echo "<script>alert('网络错误，请稍后再试');history.go(-1);</script>";
                die;
            }
        }
    }
    public function actionAddress_list()
    {
        $data=food_user_address::find()->where(['uid'=>$this->uid])->orderBy('is_default desc')->asArray()->all();
        $this->layout="layout1";
        return $this->render('address_list',['data'=>$data]);
    }
    public function actionAdd_address()
    {
        $return1=food_user_address::find()->where(['uid'=>$this->uid])->count('id');
        if(Yii::$app->request->isPost)
        {
            $data=Yii::$app->request->post();
            $data['uid']=$this->uid;
            $data['addtime']=time();
            // $this->dexit(['error'=>1,'msg'=>$data]);
            if($return1==0)
            {
                $data['is_default']=1;
            }
            unset($data['_csrf']);
            if(Yii::$app->db->createCommand()->insert('food_user_address',$data)->execute())
            {
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else
            {
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        $this->layout="layout1";
        return $this->render('add_address');
    }
    public function actionConfirmpay()
    {
        $data=Yii::$app->request->get();
        $shop=Food_shop::find()->where('id=:mid',[':mid'=>$this->mid])->asArray()->one();
        $data1=Yii::$app->db->createCommand('select a.*,b.goods_img,b.goods_name from food_order_goods as a left join food_goods as b on a.goods_id=b.id where a.order_id='.$data['order_id'])->queryAll();
        $data2=Food_order::find()->where('id=:oid',[':oid'=>$data['order_id']])->asArray()->one();
        $uid=$this->uid;
        // $session=Yii::$app->session;
        // $session->set('not_shop',false);
        if($session->get('not_shop'))
        {
            $return1=Food_user_address::find()->where(['uid'=>$uid,'is_default'=>1])->asArray()->one();
            // var_dump($return1);
            // die;
        }else
        {
            $return1=0;
        }
        if(Yii::$app->request->isPost)
        {
            $data3=$this->clear_html($_POST);
            $data3['order_no']=date(Ymd).time().rand(11111,99999);
            if($data3['remark']=='添加备注')
            {
                unset($data3['remark']);
                $data3['pay_type']='weixin';
                $data3['confirm_time']=time();
            }else
            {
                if($data3['pay_type'] != 'alipay'){
                    $data3['pay_type']='weixin';
                }
                $data3['confirm_time']=time();
            }
            //$this->dexit(array('error'=>0,'msg'=>$data3));
            $return=model('food_order')->data($data3)->where(array('id'=>$data3['order_id']))->save();
            if($return)
            {
                if($this->eid && $this->uid)
                {
                    require_once(UPLOAD_PATH.'pay_qrcode.php');
                    $a=new pay;
                    $result=model('food_order')->where(array('id'=>$data3['order_id']))->find();

                    $result2=model('shop')->where(array('id'=>$this->mid))->find();
                    $result1=model('food_payment')->where(array('cid'=>$result2['company_id']))->find();
                    // $fee,$goods_name,$truename,$appid,$apiSecret,$mch_id,$trade_no
                    $a1=$a->paying($result['total'],$result2['shop_name'],'陆江',$result1['appid'],$result1['appsecret'],$result1['mch_id'],$result['order_no'],$data3['paytype']);
                    if($a1['return_code']=='SUCCESS')
                    {
                        //取出订单表的付款状态
                        // $paystatus=model('food_order')->field('status')->where(array('id'=>$data3['order_id']))->find();
                        $this->dexit(array('error'=>2,'msg'=>$a1['code_url']));
                    }


                }else
                {
                    require_once(UPLOAD_PATH.'pay_request.php');
                    $pay=new pay;

                    $result=model('food_order')->where(array('id'=>$data3['order_id']))->find();

                    $result2=model('shop')->where(array('id'=>$this->mid))->find();
                    $result1=model('food_payment')->where(array('cid'=>$result2['company_id']))->find();
                    // $openid = 'oIXPDwlynsqQuIXTFA9LAKC1fC_E';
                    $pay1=$pay->paying($result['total'],$result2['shop_name'],'陆江',$result1['appid'],$result1['appsecret'],$result1['mch_id'],$_SESSION['openid'],$result['order_no']);//$result['order_no'];
                    //$this->dexit(array('error'=>1,'msg'=>$pay1['msg']));
                    if ($pay1['error'] == 1) {

                         exit($pay1['msg']);
                        //$this->dexit(array('error'=>0,'msg'=>json_encode($pay1)));
                    }else{

                        $this->dexit(array('error'=>1,'msg'=>$pay1['msg']));
                    }
                }

            }else {

                $this->dexit(array('error'=>1,'msg'=>'不能提交重复订单'));

            }
        }

        return $this->render('confirm',['data1'=>$data1,'shop'=>$shop,'data2'=>$data2,'return1'=>$return1,'eid'=>$this->eid]);
    }
    public function actionAdd_order_goods()
    {
        //添加订单
        $data=Yii::$app->request->get();
        $data['shop_id']=$this->mid;
        $data['uid']=$this->uid;
        $data['order_no']=date('Ymd').time().rand(11111,99999);
        $data['status']=1;
        if($this->table_id)
        {
            $data1=Food_shop_tables::find()->where('id=:tid',[':tid'=>$this->table_id])->asArray()->one();
            $data2=food_shop_tablezones::find()->where('id=:zid',[':zid'=>$data1['tablezonesid']])->asArray()->one();
            $data['seat_type']=$data2['title'];
            $data['eat_type']=1;
            $data['table_id']=$this->table_id;
        }else
        {
            $data['eat_type']=2;
        }
        $data['addtime']=time();
        $ids = rtrim($data['cat_id'],',');
        $cats=Yii::$app->db->createCommand('select * from food_cart where id in('.$ids.')')->queryAll();
        // $this->dexit(array('error'=>1,'msg'=>$cats));
        // $this->dexit(['error'=>1,'msg'=>$cats]);
        unset($data['r']);
        unset($data['csrf']);
        unset($data['cat_id']);
        $return=Yii::$app->db->createCommand()->insert('food_order',$data)->execute();
         // $this->dexit(array('error'=>1,'msg'=>'fail'));
        if($return)
        {
            $oid=Yii::$app->db->getLastInsertID();
            //桌号状态的改变
            if($this->table_id)
            {
                $return1=food_shop_tables::findOne($this->table_id);
                $return1->status=2;
                $return1->save();
            }

            foreach($cats as $v)
            {
                $result=Yii::$app->db->createCommand()->insert('food_order_goods',['shop_id'=>$this->mid,'order_id'=>$oid,'goods_id'=>$v['goods_id'],'goods_price'=>$v['goods_price'],'goods_num'=>$v['num'],'addtime'=>time()])->execute();
            }
            if($result)
            {
                $result1=Yii::$app->db->createCommand()->delete('food_cart','id in('.$ids.')')->execute();
                $this->dexit(array('error'=>0,'msg'=>$oid));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'fail'));
            }
        }

    }
    public function actionCart_index()
    {
        $data1=Food_shop::find()->where('id=:shop_id',[':shop_id'=>$this->mid])->asArray()->one();
        $data=Yii::$app->db->createCommand('select a.*,b.goods_name,b.goods_img,c.cat_name from food_cart as a left join food_goods as b on a.goods_id=b.id left join food_cat as c on b.cat_id=c.id  where a.uid='.$this->uid)->queryAll();
        $this->layout="layout1";
        return $this->render('cart_index',['data'=>$data,'data1'=>$data1]);
    }
    public function actionDelete_cart()
    {
        $data=Yii::$app->request->get();
        //删除当前用户下的该商品
        if(Yii::$app->db->createCommand()->delete('food_cart', 'goods_id='.$data['goods_id'].' and uid='.$this->uid)->execute())
        {
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else
        {
            $this->dexit(['error'=>1,'msg'=>'删除失败，请稍后再试']);
        }
    }
    public function actionCart()
    {
        //接收传过来的值
        $data=Yii::$app->request->get();
        $result=Food_cart::find()->where(['goods_id'=>$data['goods_id'],'uid'=>$this->uid])->asArray()->one();
        if($result)
        {
            //累加
            unset($data['csrf']);
            unset($data['r']);
            $data1['num']=$data['num'];
            $data1['total']=$data['num']*$data['goods_price'];
            // $this->dexit(['error'=>1,'msg'=>$data]);
            if(Yii::$app->db->createCommand()->update('food_cart',['num'=>$data1['num'],'total'=>$data1['total']],'goods_id='.$data['goods_id'].' and uid='.$this->uid)->execute())
            {
                $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else
            {
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }else
        {
            //插入一条数据
            unset($data['csrf']);
            unset($data['r']);
            $data['uid']=$this->uid;
            $data['total']=$data['goods_price']*$data['num'];
            $data['addtime']=time();
            if($this->table_id)
            {
                $data['table_id']=$this->table_id;
            }else
            {
                $data['table_id']=0;
            }
            // $this->dexit(['error'=>1,'msg'=>$data]);
            if(Yii::$app->db->createCommand()->insert('food_cart',$data)->execute())
            {
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else
            {
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
    }
    public function actionWap_menuorder()
    {
        $session=Yii::$app->session;
        if(!($session->get('not_shop')))
        {
            $session->set('not_shop',false);
        }
        if($this->table_id=='' && $this->eid=='')
        {
            $session->set('not_shop',true);
        }else
        {
            $session->set('not_shop',false);
        }
        if(!$this->eid)
        {
            $session['employee']=[];
        }
        if($this->is_weixin())
        {
            // $this->userStatus();
        }
        if($this->table_id)
        {
            //更改桌号状态为已开台
            $session['user']=[
            'uid'=>$this->uid,
            'table_id'=>$this->table_id,
            ];
            $tables=Food_shop_tables::findOne($this->table_id);
            $tables->status=1;
            $return=$tables->save();
        }
        $data=Food_cat::find()->where(['shop_id'=>$this->mid,'pid'=>0,'status'=>1])->orderBy('id desc')->asArray()->all();
        $data[0]['default']=1;
        $w = "星期" . mb_substr( "日一二三四五六",date("w"),1,"utf-8" );
        $data1=Yii::$app->db->createCommand('select distinct a.cat_id,a.*,b.cat_name from food_goods as a left join food_cat as b on a.cat_id=b.id where  a.shop_id='.$this->mid.' and a.is_onsale=1 and a.goods_today_stock>0 and a.suppy_time LIKE "%'.$w.'%" order by b.sort desc')->queryAll();
        $data1[0]['default']=2;
        // $this->layout="layout2";
        return $this->render('wap_menuorder',['data'=>$data,'data1'=>$data1,'mid'=>$this->mid,'table_id'=>$this->table_id]);
    }
    public function actionChoosetable()
    {
        //手机端选桌子页面
        $data1=Food_shop_tables::find()->where(['status'=>0,'store_id'=>$this->mid])->asArray()->all();
        if($data1)
        {
            $session=Yii::$app->session;
            $id=isset($session['user']['table_id'])?$session['user']['table_id']:0;
            //如果用户选定了桌子就不允许再选
            $return=Yii::$app->db->createCommand('select * from food_shop_tables where status in(1,2,3) and store_id='.$this->mid.' and id='.$id)->queryAll();
            if($session['user']['uid']==$this->uid && $return)
            {
                if($return[0]['status']==3)
                {
                    echo '<script>alert("你已有桌号，请勿重复选桌,换桌请联系服务员");location.href="?r=plugin/myself/default/paid";</script>';
                    die;
                }else
                {
                    echo '<script>alert("你已有桌号，请勿重复选桌");location.href="?r=plugin/users/default/wap_menuorder";</script>';
                }
            }
        }else{
                if($this->eid)
                {
                   header('Location:/index.php?r=plugin/shops/index/do_entrance_waiter');
                   die;
                }
                //没有空闲桌子则进入排队
                 echo "<script>alert('已没有空闲餐桌，请先取号排队');location.href='?r=plugin/users/default/do_queue_buyer&shop_id=".$this->mid."';</script>";
            }
        $this->layout="layout2";
        return $this->render('choosetable',['data1'=>$data1,'mid'=>$this->mid]);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionHomepage()
    {
        return $this->render('homepage');
    }
    public function actionGetwx_location()
    {
        $session=Yii::$app->session;
        $data=Yii::$app->request->get();
        $payment=food_payment::find()->where('cid=:id',[':id'=>$this->cid])->asArray()->one();
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //对当前url进行加密
        $url=base64_encode(json_encode($url));
        //请求乐呗获取微信授权的接口
        $request=new CommonApi;
        $ret=$request->getinfo($url);
        if($ret['return_code']=='SUCCESS')
        {
            $wxinfo=json_decode(base64_decode($ret['content']),true);
        }
        return $this->render('getwx_location',['wxinfo'=>$wxinfo]);
    }
    public function actionShop_list()
    {
        if(Yii::$app->request->isPost)
        {
            $data=Yii::$app->request->post();
            $data1=Yii::$app->db->createCommand('select *,ROUND(6378.138*2*ASIN(SQRT(POW(SIN(('.$data['lat'].'*PI()/180-lat*PI()/180)/2),2)+COS('.$data['lat'].'*PI()/180)*COS(lat*PI()/180)*POW(SIN(('.$data['lng'].'*PI()/180-lng*PI()/180)/2),2)))*1000) AS distance from food_shop where company_id='.$this->cid.' order by distance')->queryAll();
            if($data1)
            {
                $this->dexit(array('error'=>0,'msg'=>$data1));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'暂无商家'));
            }
        }
    }
    public function actionWap_bill()
    {
        $this->layout="layout2";
        return $this->render('wap_bill');
    }
    public function actionWap_callout()
    {
        $this->layout="layout2";
        return $this->render('wap_callout');
    }
    public function actionWap_more()
    {
        $this->layout="layout2";
        return $this->render('wap_more');
    }
}
