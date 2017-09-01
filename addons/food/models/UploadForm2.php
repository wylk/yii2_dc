<?php
namespace app\addons\food\models;
use yii\base\Model;
use yii\web\UploadedFile;
class UploadForm2 extends Model
{
    public $imageFiles;
    public $path;
    public $file_path;
    public $field_path;
    public function rules()
    {
        return [
            // ['imageFiles','required','message'=>'请上传相应的图片'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4,'checkExtensionByMimeType'=>false,'uploadRequired'=>'请上传相应的图片'],
        ];
    }
    public function upload($cid,$type)
    {
        if ($this->validate()) {
            $this->field_path=[];
            foreach ($this->imageFiles as $k=>$file) {
               $this->path='./uploads/images/'.$cid.'/';
                if(!file_exists($this->path))
                {
                    mkdir($this->path);
                }
                $this->path.=$type.'/';
                if(!file_exists($this->path))
                {
                    mkdir($this->path);
                }
                $this->file_path=$this->path.date('Ymd').uniqid().$file->baseName . '.' . $file->extension;
                $this->field_path[]=$this->file_path;
                $file->saveAs( $this->file_path);
            }
            return true;
        } else {
            return false;
        }
    }
}