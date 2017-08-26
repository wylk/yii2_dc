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

    public function init()
    {
    	$session = Yii::$app->session;
    	//var_dump($session->get('employee'));die;
        /*if (Yii::$app->session['employee'] != true) {
            return $this->redirect(['?r=plugin/publics/default/index']);
        }*/
        $this->layout = 'layout1';
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
}