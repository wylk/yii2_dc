<?php

namespace app\addons\food\publics\controllers;

use yii\web\Controller;
use app\addons\food\models\Food_company;
/**
 * Default controller for the `publics` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    //登录入口
    public function actionIndex()
    {
    	$this->layout = "layout1";
        return $this->render('index');
    }
    //商家登录
    public function actionSuper_login()
    {
    	$this->layout = "layout1";
    	return $this->render('super_login');
    }
    //商家申请入住
    public function actionCreate_company()
    {
    	
    	return $this->render('create_company');

    }
    //员工登录
    public function actionShop_login()
    {
    	$this->layout = "layout1";
    	return $this->render('shop_login');

    }
}
