<?php
namespace app\web\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\web\modules\models\Food_company;
use yii\data\Pagination;
class CompanyController extends Controller
{
    public function actionWait_checking()
    {
        // $data=Food_company::find()->where(['status'=>0])->asArray()->all();
        $count= Food_company::find()->where(['status'=>0])->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => '15']);
        $data = Food_company::find()->where(['status'=>0])->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $this->layout="layout1";
        return $this->render('wait_checking',['data'=>$data,'pages'=>$pages]);
    }
    public function actionPass()
    {
        $data=Yii::$app->request->get();
        $company=Food_company::findOne($data['id']);
        $company->status=1;
        if($company->save())
        {
            echo "<script>alert('通过成功');location.href='?r=admin/company/wait_checking';</script>";
            die;
        }else
        {
            echo "<script>alert('通过失败');location.href=?r=admin/company/wait_checking;</script>";
            die;
        }
    }
    public function actionReject()
    {
        $data=Yii::$app->request->get();
        $company=Food_company::findOne($data['id']);
        $company->status=2;
        if($company->save())
        {
            echo "<script>alert('驳回成功');location.href='?r=admin/company/wait_checking';</script>";
            die;
        }else
        {
            echo "<script>alert('驳回失败，请稍后再试');location.href='?r=admin/company/wait_checking';</script>";
            die;
        }
    }
}