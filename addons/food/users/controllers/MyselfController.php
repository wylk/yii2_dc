<?php
namespace app\addons\food\users\controllers;
use yii;
use app\addons\food\models\Food_order;
use app\addons\food\models\Food_shop;
use app\addons\food\models\Food_order_goods;
use app\addons\food\models\Food_cart;
use app\addons\food\models\Food_goods;
class MyselfController extends CommonController
{
    public function init()
    {
        parent::init();
        $view = Yii::$app->view;
        $view->params['mid'] = $this->mid;
        if($this->uid=='')
        {
            echo "<script>alert('非法访问');location.href='?r=plugin/users/default/wap_menuorder&shop_id=7'</script>";
            die;
        }
    }
    public function actionTest()
    {
        echo $this->mid;
    }
    public function actionUnpay()
    {
        $data=Yii::$app->db->createCommand('SELECT a . * , b.shop_name
        FROM  `food_order` AS a
        LEFT JOIN food_shop AS b ON a.shop_id = b.id
        WHERE a.status =1
        AND a.uid ='.$this->uid.' order by a.addtime desc')->queryAll();
        $data1=[];
        foreach($data as $v)
        {
            $data1[]=Yii::$app->db->createCommand('select a.*,b.goods_img,b.goods_name from food_order_goods as a left join food_goods as b on a.goods_id=b.id where a.order_id='.$v['id'])->queryAll();
        }
        $this->layout="layout2";
        return $this->render('unpay',['data'=>$data,'data1'=>$data1,'mid'=>7]);
    }
    public function actionPaid()
    {
        $data=Yii::$app->db->createCommand('SELECT a . * , b.shop_name
        FROM  `food_order` AS a
        LEFT JOIN food_shop AS b ON a.shop_id = b.id
        WHERE a.status =2
        AND a.uid ='.$this->uid.' order by a.confirm_time desc')->queryAll();
        $data1=[];
        foreach($data as $v)
        {
            $data1[]=Yii::$app->db->createCommand('select a.*,b.goods_img,b.goods_name from food_order_goods as a left join food_goods as b on a.goods_id=b.id where a.order_id='.$v['id'])->queryAll();
        }
       $this->layout="layout2";
        return $this->render('paid',['data'=>$data,'data1'=>$data1]);
    }
    public function actionDone()
    {
        $data=Yii::$app->db->createCommand('SELECT a . * , b.shop_name
        FROM  `food_order` AS a
        LEFT JOIN food_shop AS b ON a.shop_id = b.id
        WHERE a.status =3
        AND a.uid ='.$this->uid.' order by a.paid_time desc')->queryAll();
        $data1=[];
        foreach($data as $v)
        {
            $data1[]=Yii::$app->db->createCommand('select a.*,b.goods_img,b.goods_name from food_order_goods as a left join food_goods as b on a.goods_id=b.id where a.order_id='.$v['id'])->queryAll();
        }
       $this->layout="layout2";
        return $this->render('done',['data'=>$data,'data1'=>$data1]);
    }
    public function actionCart_list()
    {
        $data=Yii::$app->db->createCommand('select a.* from food_shop as a left join food_cart as b on a.id=b.shop_id where b.uid='.$this->uid.' group by a.id')->queryAll();
        $data1=Yii::$app->db->createCommand('select a.*,b.goods_name,b.goods_img,c.cat_name from food_cart as a left join food_goods as b on a.goods_id=b.id left join food_cat as c on b.cat_id=c.id where a.uid='.$this->uid)->queryAll();
        $this->layout="layout2";
        return $this->render('cart_list',['data'=>$data,'data1'=>$data1]);
    }
    public function actionAll_order()
    {
        $data=Yii::$app->db->createCommand('SELECT a . * , b.shop_name
        FROM  `food_order` AS a
        LEFT JOIN food_shop AS b ON a.shop_id = b.id
        WHERE a.status in(1,2,3)
        AND a.uid ='.$this->uid)->queryAll();
        $data1=[];
        foreach($data as $v)
        {
            $data1[]=Yii::$app->db->createCommand('select a.*,b.goods_img,b.goods_name from food_order_goods as a left join food_goods as b on a.goods_id=b.id where a.order_id='.$v['id'])->queryAll();
        }
        $this->layout="layout2";
        return $this->render('all_order',['data'=>$data,'data1'=>$data1]);
    }
    public function actionDel_order()
    {
        $data=Yii::$app->request->get();
        $orders=Food_order::findOne($data['order_id']);
        $orders->status=0;
        if($orders->save())
        {
            echo "<script>alert('取消订单成功');location.href='?r=plugin/users/myself/unpay'</script>";
            die;
        }else
        {
            echo "<script>alert('取消订单失败');location.href='?r=plugin/users/myself/unpay'</script>";
            die;
        }
    }
    public function actionView_recode()
    {
       $this->layout="layout2";
        return $this->render('view_recode');
    }

}