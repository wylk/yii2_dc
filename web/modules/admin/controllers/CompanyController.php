<?php
namespace app\web\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\web\modules\models\Food_company;
use yii\data\Pagination;
use app\addons\food\models\Food_store_auth;
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
    //店铺菜单管理
    public function actionShop_menu()
    {
        $this->layout="layout1";
        $authInfo = Food_store_auth::find()->where('')->asArray()->orderBy('id asc')->all();
        $authInfos = $this->GetTree($authInfo,0,0);
        return $this->render('shopmenu',['authInfos'=>$authInfos]);
    }

    //删除店铺菜单
    public function actionDel_menu()
    {
        $id = Yii::$app->request->get('id');
        $auths = Food_store_auth::find()->where(['auth_pid'=>$id])->one();
        if($auths == true){
            $this->dexit(['error'=>1,'msg'=>'菜单还有子菜单不能删除！']);
        }

        if(Food_store_auth::findOne($id)->delete()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        }else{
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }
    //添加店铺菜单
    public function actionAddmenu()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            unset($data['_csrf']);
            if (Yii::$app->db->createCommand()->insert('food_store_auth',$data)->execute()) {
                $this->dexit(['error'=>0,'msg'=>'添加成功']); 
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }

        }
        $this->layout="layout1";
        $authInfo = Food_store_auth::find()->where(['auth_pid'=>0])->asArray()->all();
        return $this->render('addmenu',['authInfo'=>$authInfo]);

    }
    //修改店铺菜单
    public function actionMenu_edit()
    {
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $id = $data['id'];
            unset($data['_csrf'],$data['id']);
            $auths = Food_store_auth::find()->where(['auth_pid'=>$id])->one();
            if($auths == true){
                $this->dexit(['error'=>1,'msg'=>'菜单还有子菜单不能修改！']);
            }
            if (Yii::$app->db->createCommand()->update('food_store_auth',$data,'id='.$id)->execute()) {
               $this->dexit(['error'=>0,'msg'=>'修改成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'修改失败']);
            }
        }
        $this->layout="layout1";
        $id = Yii::$app->request->get('id');
        $authInfo1 = Food_store_auth::find()->where(['id'=>$id])->asArray()->one();
        $authInfo = Food_store_auth::find()->where(['auth_pid'=>0])->asArray()->all();
        return $this->render('menu_edit',['authInfo1'=>$authInfo1,'authInfo'=>$authInfo]);
    }
    public function GetTree($arr,$pid,$step){
        global $tree;
        foreach($arr as $key=>$val) {
            if($val['auth_pid'] == $pid) {
                $flg = str_repeat('└―',$step);
                $val['name'] = $flg.$val['name'];
                $tree[] = $val;
                $this->GetTree($arr , $val['id'] ,$step+1);
            }
        }
            return $tree;
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