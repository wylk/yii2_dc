<?php
namespace app\addons\food\stores\controllers;
use app\addons\food\stores\controllers\CommonController;
use app\addons\food\stores\models\User;
use Yii;
/**
 * Default controller for the `stores` module
 */
class HomepageController extends CommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = false;
    public function actionIndex()
    {
        $this->layout = "layout2";
        return $this->render('index');
    }
    public function actionStores_manage()
    {
        $this->layout="layout2";
        return $this->render('stores_manage');
    }
    public function actionCompany_page()
    {
        $this->layout="layout2";
        return $this->render('company_page');
    }
    public function actionOrder_list()
    {
        $this->layout="layout2";
        return $this->render('order_list');
    }
    public function actionStores_type()
    {
        $this->layout="layout2";
        return $this->render('stores_type');
    }
    public function actionShopkeeper()
    {
        $this->layout="layout2";
        return $this->render('shopkeeper');
    }
    public function actionPayment()
    {
        $this->layout="layout2";
        return $this->render('payment');
    }

}
