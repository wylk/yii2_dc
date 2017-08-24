<?php

namespace app\addons\food\shops\controllers;

use yii\web\Controller;

/**
 * Default controller for the `shops` module
 */
class DefaultController extends Controller
{
    public $layout = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
}
