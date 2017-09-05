<?php
namespace app\addons\food\stores\controllers;
use yii\web\Controller;
use Yii;
class CommonController extends  Controller
{
    public $cid;
    public $phone;
    public $shop_name;
    public function init()
    {
        parent::init();
        header("Content-type: text/html; charset=utf-8");
        $session=Yii::$app->session;
        $session->open();
        $this->cid=$session->get('cid');
        $this->phone=$session->get('phone');
        $this->shop_name=$session->get('shop_name');
        $view = Yii::$app->view;
        $view->params['phone'] = $this->phone;

        if($this->cid == false)
        {
            header('Location:?r=plugin/publics/default/super_login');die;
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