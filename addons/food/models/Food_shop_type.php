<?php

namespace app\addons\food\models;
use yii\db\ActiveRecord;
use Yii;
class Food_shop_type extends ActiveRecord
{
    public function rules()
    {
        return [
            ['typename','required','message'=>'门店类型名称不能为空'],
        ];
    }
}