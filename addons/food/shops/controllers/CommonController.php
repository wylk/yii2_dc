<?php

namespace app\addons\food\shops\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `shops` module
 */
class CommonController extends Controller
{
    public $layout = false;
    public $mid = '';
    public function init()
    {
    	$session = Yii::$app->session;
    	//var_dump($session->get('employee'));die;
        /*if (Yii::$app->session['employee'] != true) {
            return $this->redirect(['?r=plugin/publics/default/index']);
        }*/
        
        $this->layout = 'layout1';
        $this->mid = Yii::$app->session['employee']['shop_id'];
    }


    public function actionIndex()
    {
    	//$session = Yii::$app->session;
    	//var_dump($session->get('employee'));
        //return $this->render('index');
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