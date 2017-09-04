<?php
namespace app\addons\food\publics\controllers;
use Yii;
use yii\web\Controller;
use app\addons\food\models\Food_company;
use app\addons\food\models\Food_employee;
use app\addons\food\models\UploadForm2;
use app\vendor\org\CommonApi;
use yii\web\UploadedFile;
/**
 * Default controller for the `publics` module
 */
class TestController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionToken()
    {
       echo Yii::$app->request->csrfToken;
    }
   
}