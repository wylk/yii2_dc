<?php

namespace app\addons\food\shops\controllers;

use Yii;
use yii\web\Controller;
use app\addons\food\models\Food_company;
use app\addons\food\models\Food_shop;
use app\addons\food\models\Food_store_role;

/**
 * Default controller for the `shops` module
 */
class CommonController extends Controller
{
    public $layout = false;
    public $mid = '';
    public function init()
    {
        if(isset(Yii::$app->request->get()['store_id'])){
            $this->mid = Yii::$app->request->get('store_id');
        }else{
            $this->mid = Yii::$app->session['employee']['shop_id'];
        }

        list($sss1,$dssd,$a,$c) = explode('/',Yii::$app->request->get('r')); 
        $nowAC = $a.'-'.$c;
        $allAC = "index-index,index-left_menu,index-test11";

        if(Yii::$app->session['cid']){
            $cid = Yii::$app->session['cid'];
            $shops = Food_shop::find()->where(['company_id'=>$cid,'id'=>$this->mid])->asArray()->one();

            if($shops == false && strpos($allAC,$nowAC) == false){
                echo "<script>alert('非法访问！');window.history.go(-1);</script>";die;
            }

        }
        if (empty(Yii::$app->session['employee']) && empty(Yii::$app->session['cid'])) {
            echo   '<script> window.top.location.href = "?r=plugin/publics/default/index";</script>';
        }else{
            if (isset(Yii::$app->session['employee']) && Yii::$app->session['employee']['role_id'] != 0) {
                $roles = Food_store_role::find()->where(['store_id'=>$this->mid,'id'=>Yii::$app->session['employee']['role_id']])->asArray()->one();
                $role = $roles['role_auth_ac'];
            }else{
                $role = false;
            }
            if (strpos($role,$nowAC) === false && strpos($allAC,$nowAC) === false && Yii::$app->session['employee']['role_id'] != 0 && empty(Yii::$app->session['cid']) ){
                echo "<script>alert('非法访问!!');window.history.go(-1);</script>";die;
            }
        }
        //dump(Yii::$app->session['cid']);
        $this->layout = 'layout1';
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

    public function arr2_arr1($arrdata,$v)
    {
        $arrs = array();
        foreach ($arrdata as $key => $value) {
            $arrs[] = $value[$v];
        }
        return $arrs;
    }

    public function clear_html($array) 
    {
        if (!is_array($array))
            return trim(htmlspecialchars($array, ENT_QUOTES));
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $this->clear_html($value);
                } else {
                    $array[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
                }
            }
        return $array;
    }
}