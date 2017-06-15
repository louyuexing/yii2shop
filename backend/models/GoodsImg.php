<?php

namespace backend\models;

use liyunfang\file\UploadBehavior;
use Yii;

/**
 * This is the model class for table "goods_img".
 *
 * @property integer $good_id
 * @property string $img
 */
class GoodsImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public static function tableName()
    {
        return 'goods_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'good_id' => 'Good ID',
            'img' => '商品图片',
        ];

    }
    /**
     * @inheritdoc
     */

}

























