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
/**
 * Default controller for the `users` module
 $user = new CommonApi($apiarr);
 $user->getinfo()
 */
class DefaultController extends CommonController
{
    public function actionCart_index()
    {
        $data1=Food_shop::find()->where('id=:shop_id',[':shop_id'=>$this->mid])->asArray()->one();
        $data=Yii::$app->db->createCommand('select a.*,b.goods_name,b.goods_img,c.cat_name from food_cart as a left join food_goods as b on a.goods_id=b.id left join food_cat as c on b.cat_id=c.id  where a.uid='.$this->uid)->queryAll();
        $this->layout="layout1";
        return $this->render('cart_index',['data'=>$data,'data1'=>$data1]);
    }
    public function actionCart()
    {
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            $this->dexit(['error'=>1,'msg'=>$post]);
        }
        // //接收传过来的值
        // $data=Yii::$app->request->get();
        // $this->dexit(array('error'=>1,'msg'=>$data));
        // $data=$this->clear_html($_GET);
        // // $this->dexit(array('error'=>1,'msg'=>$));
        // $result=model('food_cart')->where(array('goods_id'=>$data['goods_id'],'uid'=>$this->uid))->find();
        //  // $this->dexit(array('error'=>1,'msg'=>$this->uid));
        // if($result)
        // {
        //     //累加
        //     $data1['num']=$data['num'];
        //     $data1['total']=$data['num']*$data['goods_price'];
        //     // $this->dexit(array('error'=>0,'msg'=>$data1));
        //     $return1=model('food_cart')->data($data1)->where(array('goods_id'=>$data['goods_id'],'uid'=>$this->uid))->save();
        //     if($return1)
        //     {
        //         $this->dexit(array('error'=>0,'msg'=>'修改成功'));
        //     }else
        //     {
        //         $this->dexit(array('error'=>1,'msg'=>'修改失败'));
        //     }

        // }else
        // {
        //     $data['shop_id']=$this->mid;
        //     if($this->table_id){
        //         $data['table_id']=$this->table_id;
        //     }else{
        //         $data['table_id'] = 0;
        //     }
        //     $data['uid']=$this->uid;
        //     $data['num']=$data['num'];
        //     $data['total']=$data['num']*$data['goods_price'];
        //     $data['addtime']=time();
        //     // $this->dexit(array('error'=>1,'msg'=>$data));
        //     $return=model('food_cart')->data($data)->add();
        //     if($return)
        //     {
        //         $this->dexit(array('error'=>0,'msg'=>'添加成功'));
        //     }else
        //     {
        //         $this->dexit(array('error'=>1,'msg'=>'添加失败'));
        //     }
        // }
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
            $data1=Yii::$app->db->createCommand('select *,ROUND(6378.138*2*ASIN(SQRT(POW(SIN(('.$data['lat'].'*PI()/180-lat*PI()/180)/2),2)+COS('.$data['lat'].'*PI()/180)*COS(lat*PI()/180)*POW(SIN(('.$data['lng'].'*PI()/180-lng*PI()/180)/2),2)))*1000) AS distance from hd_shop where company_id='.$this->cid.' order by distance')->queryAll();
            if($data1)
            {
                $this->dexit(array('error'=>0,'msg'=>$data1));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'暂无商家'));
            }
        }
    }
}
