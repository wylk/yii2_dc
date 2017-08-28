<?php
namespace app\addons\food\stores\controllers;
use app\addons\food\stores\controllers\CommonController;
use app\addons\food\stores\models\User;
use Yii;
use app\addons\food\models\Food_shop;
use app\addons\food\models\Food_shop_type;
use app\addons\food\models\Test;
use yii\data\Pagination;
use app\addons\food\models\UploadForm;
use yii\web\UploadedFile;
use app\addons\food\models\Food_employee;

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
        //门店管理关联查询以及分页
        $count=Food_shop::find()->where(['company_id'=>$this->cid])->count();
        $pageSize = Yii::$app->params['pageSize']['homepage'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $where='';
        $data1='';
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            if($post['shop_name'])
            {
                $where=' and a.shop_name="'.$post['shop_name'].'"';
                $data1=Food_shop::find()->where(array('shop_name'=>$post['shop_name']))->asArray()->one();
            }else
            {
                $where='';
            }
        }
        if($data1)
        {
            $data=Yii::$app->db->createCommand('select a.*,b.typename from food_shop as a left join food_shop_type as b on a.type_id=b.id where a.company_id='.$this->cid.$where.'  order by a.add_time desc')->queryAll();
        }else
        {
            $data=Yii::$app->db->createCommand('select a.*,b.typename from food_shop as a left join food_shop_type as b on a.type_id=b.id where a.company_id='.$this->cid.$where.'  order by a.add_time desc limit '.$pager->offset.','.$pager->limit)->queryAll();
        }
        $this->layout="layout2";
        return $this->render('stores_manage',['data'=>$data,'pager'=>$pager,'data1'=>$data1]);
    }
    public function actionTest()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload($this->cid,'shop_logo')) {
                // 文件上传成功
                echo $model->file_path;
            }
        }
        return $this->render('test',['model'=>$model]);
        // $data['score']=101;
        // $data['age']=34;
        // $return=Yii::$app->db->createCommand()->update('test', $data, 'id=1')->execute();
        // if($return)
        // {
        //     echo 'success';
        // }else
        // {
        //     echo 'fail';
        // }
        //yii添加
        // $model=new Test;
        // $post=Yii::$app->request->get();//更改id=1的数据
        // $model=Test::find()->where(['id'=>$post['id']])->one();
        // // var_dump($model);
        // // die;
        // $model['score']=$post['score'];
        // $model['age']=$post['age'];
        // // $data['score']=45;
        // // $model['score']=66;
        // if($model->save())
        // {
        //     echo 'success';
        // }else
        // {
        //     echo 'fail';
        // }
        // $data['score']=100;
        // $data['name']=50;
        // $data['age']=60;
        // if(Yii::$app->db->createCommand()->insert('test',$data)->execute())
        // {
        //     echo 'success';
        // }else
        // {
        //     echo 'fail';
        // }
    }
    public function actionCreate_shop()
    {
        //创建门店
        $data=Food_shop_type::find()->where(array('cid'=>$this->cid))->asArray()->all();
        // $data1=$this->clear_html($_GET);
        $data1=Yii::$app->request->get();

        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            $post['add_time']=time();
            $post['company_id']=$this->cid;
            //对店铺经纬度的处理
            $map=explode(',',$post['shop_location']);
            $post['lat']=$map[1];
            $post['lng']=$map[0];
            unset($post['_csrf']);
            unset($post['shop_location']);
            //插入到数据库
            if(Yii::$app->db->createCommand()->insert('food_shop',$post)->execute())
            {
                $this->dexit(array('error'=>0,'msg'=>'创建成功'));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'创建失败，请稍后再试'));
            }
        }
        $this->layout="layout2";
        return $this->render('create_shop',['data'=>$data,'data1'=>$data1]);
    }
    public function actionShop_edit()
    {
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post();
            $map=explode(',',$post['shop_location']);
            $post['lat']=$map[1];
            $post['lng']=$map[0];
            unset($post['shop_location']);
            unset($post['_csrf']);
            // $this->dexit(array('error'=>1,'msg'=>$post));
            $return=Yii::$app->db->createCommand()->update('food_shop', $post, 'id = '.$post['id'])->execute();
            if($return)
            {
                $this->dexit(array('error'=>0,'msg'=>'修改成功'));
            }else
            {
                $this->dexit(array('error'=>1,'msg'=>'请至少选择一项修改'));
            }

        }
        $data=Yii::$app->request->get();
        $data1=Food_shop::find()->where('id=:bid',[':bid'=>$data['bid']])->asArray()->one();
        $data2=Food_shop_type::find()->where('cid=:company_id',[':company_id'=>$this->cid])->asArray()->all();
        $this->layout="layout2";
        return $this->render('shop_edit',['data1'=>$data1,'data2'=>$data2,'data'=>$data]);
    }
    public function actionShop_del()
    {
        $data=Yii::$app->request->get();
        if(Yii::$app->db->createCommand()->delete('food_shop', 'id = '.$data['bid'])->execute())
        {
            echo "<script>alert('删除成功');location.href=history.go(-1);</script>";
            die;
        }else
        {
            Yii::$app->session->setFlash('info', '删除失败，请稍后再试');
        }
    }
    public function actionBaidu_map()
    {
        $this->layout="layout2";
        return $this->render('baidu_map');
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
        $_count=Food_shop_type::find()->where(['cid'=>$this->cid])->count();
        $pageSize = Yii::$app->params['pageSize']['homepage'];
        $pager = new Pagination(['totalCount' => $_count, 'pageSize' => $pageSize]);
        $where='';
        $data1='';
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            if($post['typename'])
            {
                $where=' and typename="'.$post['typename'].'"';
                $data1=Food_shop_type::find()->where(array('typename'=>$post['typename']))->asArray()->one();
            }else
            {
                $where='';
            }
        }
        if($data1)
        {
            $data=Yii::$app->db->createCommand('select * from food_shop_type  where cid='.$this->cid.$where.'  order by create_time desc ')->queryAll();
        }else
        {
            $data=Yii::$app->db->createCommand('select * from food_shop_type  where cid='.$this->cid.$where.'  order by create_time desc limit '.$pager->offset.','.$pager->limit)->queryAll();
        }
        $this->layout="layout2";
        return $this->render('stores_type',['data'=>$data,'data1'=>$data1,'pager'=>$pager]);
    }
    public function actionCreate_shop_type()
    {
        $model = new UploadForm();
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->upload($this->cid,'shop_logo'))
            {
                // 文件上传成功
                $type_img=$model->file_path;
            }
            unset($post['_csrf']);
            unset($post['UploadForm']);
            $post['type_img']=$type_img;
            $post['cid']=$this->cid;
            $post['create_time']=time();
            if(Yii::$app->db->createCommand()->insert('food_shop_type',$post)->execute())
            {
                echo "<script>alert('添加成功');location.href='?r=plugin/stores/homepage/stores_type';</script>";
                die;
            }else
            {
                echo "<script>alert('添加失败,请稍后再试');location.href=history.go(-1);</script>";
                die;
            }

        }
        $this->layout="layout2";
        return $this->render('create_shop_type',['model'=>$model]);
    }
    public function actionShop_type_edit()
    {
        $model=new UploadForm();
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            $data2=Food_shop_type::find()->where(['id'=>$post['id']])->asArray()->one();
            if($data2)
            {
                unlink($data2['type_img']);
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if($model->upload($this->cid,'shop_logo'))
                {
                    // 文件上传成功
                    $type_img=$model->file_path;
                }
                unset($post['_csrf']);
                unset($post['UploadForm']);
                $post['type_img']=$type_img;
                // var_dump($post);
                // die;
                //更改数据
                if(Yii::$app->db->createCommand()->update('food_shop_type', $post, 'id = '.$post['id'])->execute())
                {
                    echo "<script>alert('修改成功');location.href='?r=plugin/stores/homepage/stores_type'</script>";
                    die;
                }else
                {
                    echo "<script>alert('修改失败，请稍后再试');location.href=history.go(-1);</script>";
                    die;
                }
            }
        }
        $data=Yii::$app->request->get();
        $data1=Food_shop_type::find()->where(['id'=>$data['sid']])->one();
        $this->layout="layout2";
        return $this->render('shop_type_edit',['model'=>$model,'data1'=>$data1]);
    }
    public function actionShop_type_del()
    {
        $data=Yii::$app->request->get();
        $model=Food_shop_type::findOne($data['id']);
        if($model->delete())
        {
            echo "<script>alert('删除成功');location.href='?r=plugin/stores/homepage/stores_type';</script>";
            die;
        }else
        {
            echo "<script>alert('删除失败，请稍后再试');location.href=history.go(-1);</script>";
        }
    }
    public function actionShopkeeper()
    {
        //获取所有的店铺
        $shop=Food_shop::find()->where(['company_id'=>$this->cid])->asArray()->all();
        $shop_id='';
        foreach($shop as $v)
        {
            $shop_id.=$v['id'].',';
        }
        $shop_id=rtrim($shop_id,',');
        $where=' role_id=0 and status=1 and shop_id in('.$shop_id.')';
        $count=Food_employee::find()->where($where)->count();
        $pageSize=Yii::$app->params['pageSize']['homepage'];
        $pager=new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $where1='';
        $data1='';
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            if($post['truename'])
            {
                $where1=' and a.truename="'.$post['truename'].'"';
                $data1=Food_employee::find()->where(array('truename'=>$post['truename']))->asArray()->one();
            }else
            {
                $where1='';
            }
        }
        if($data1)
        {
            $data=Yii::$app->db->createCommand('select a.*,b.shop_name from food_employee as a left join food_shop as b on a.shop_id=b.id where a.role_id=0 '.$where1.'  and a.shop_id in ('.$shop_id.') and a.status=1 order by a.create_time desc')->queryAll();
        }else
        {
            $data=Yii::$app->db->createCommand('select a.*,b.shop_name from food_employee as a left join food_shop as b on a.shop_id=b.id where a.role_id=0 '.$where1.'  and a.shop_id in ('.$shop_id.') and a.status=1 order by a.create_time desc limit '.$pager->offset.','.$pager->limit)->queryAll();
        }
        $this->layout="layout2";
        return $this->render('shopkeeper',['pager'=>$pager,'data'=>$data,'data1'=>$data1]);
    }
    public function actionCreate_employee()
    {
        if(Yii::$app->request->isPost)
        {
            $post=Yii::$app->request->post();
            //判断登陆账号是否存在
            $data1=Food_employee::find()->where('username=:user',[':user'=>$post['username']])->asArray()->one();
            if($data1)
            {
                $this->dexit(array('error'=>1,'msg'=>'登录账号已存在'));
            }

        }
        $data=Food_shop::find()->where(['company_id'=>$this->cid])->all();
        $this->layout="layout2";
        return $this->render('create_employee',['data'=>$data]);
    }
    public function actionPayment()
    {
        $this->layout="layout2";
        return $this->render('payment');
    }
    public function actionLogout()
    {
        $session=Yii::$app->session;
        $session->remove('cid');
        $session->remove('phone');
        if(!$this->cid)
        {
            header('Location:?r=plugin/publics/default/super_login');
        }
    }

}
