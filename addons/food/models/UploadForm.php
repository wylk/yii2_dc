<?php
namespace app\addons\food\models;
use yii\base\Model;
use yii\web\UploadedFile;
<<<<<<< HEAD
// use yii\db\ActiveRecord;
=======
>>>>>>> add1
class UploadForm extends Model
{
    public $imageFile;
    public $path;
    public $file_path;
    // public $typename;
    public function rules()
    {
        return [
            // ['typename','required','message'=>'门店类型名称不能为空'],
            // ['typename','safe'],
            ['imageFile','required','message'=>'你还没有上传任何文件'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxSize'=>1024000,'checkExtensionByMimeType'=>false],
        ];
    }
    public function upload($cid,$type)
    {
            if ($this->validate()) {
                $this->path='./uploads/images/'.$cid.'/';
                if(!file_exists($this->path))
                {
                    mkdir($this->path);
                }
                $this->path.=$type.'/';
                if(!$this->path)
                {
                    mkdir($this->path);
                }
                $this->file_path=$this->path . date('Ymd').$this->imageFile->baseName .uniqid(). '.' . $this->imageFile->extension;
                if($this->imageFile->saveAs($this->file_path)){
                    return true;
                }else {
                    return false;
                }
            }

    }

    public function goodsUpload($cid,$type)
    {
        if ($this->validate()) {
            $this->path='./uploads/images/goods/'.$cid.'/';
            if(!file_exists($this->path))
            {
                mkdir($this->path);
            }
            $this->file_path=$this->path.$this->imageFile->baseName . '.' . $this->imageFile->extension;
            //$this->file_path=$this->path . date('Ymd').$this->imageFile->baseName . '.' . $this->imageFile->extension;
            if($this->imageFile->saveAs($this->file_path)){
                return true;
            }else {
                return false;
            }
        }

    }
}