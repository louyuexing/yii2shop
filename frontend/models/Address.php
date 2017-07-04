<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $provinces
 * @property string $city
 * @property string $area
 * @property string $addressinfo
 * @property integer $phone
 * @property integer $status
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $id;

    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'provinces', 'city', 'area', 'addressinfo','phone'],'required'],
            [['phone'], 'integer'],
            [['name','addressinfo'], 'string', 'max' => 255],
            ['status','boolean'],
            ['area','validateArea'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收件人',
            'provinces' => '省份',
            'city' => '市县',
            'area' => '城镇',
            'addressinfo' => '详细地址',
            'phone' => '电话号码',
            'status' => '是否为默认地址',
        ];
    }

    public function Address($id){

        $result=Locations::findOne(['id'=>$id]);
        $name=$result->name;
//        var_dump($result->name);exit;
       echo $name;
    }

    public function Addre($id){

        $result=Locations::findOne(['id'=>$id]);
        $name=$result->name;
        return $name;
    }


    public function beforeSave($insert){
        if($this->status){
            $result=Address::findAll(['status'=>$this->status]);
            foreach ($result as $row){
                $row->status=0;
                $row->save();
                return true;
            }
        }return true;
    }

    public function validateArea(){
        if($this->area==null){
           return $this->addError('area','请选择区域');
        }

    }
}
