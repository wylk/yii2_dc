<?php

namespace app\addons\food\users\controllers;

use yii\web\Controller;

/**
 * Default controller for the `users` module
 */
class DefaultController extends Controller
{
	public $layout = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
}
