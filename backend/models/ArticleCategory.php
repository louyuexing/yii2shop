<?php

namespace backend\models;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $sort
 * @property integer $status
 * @property integer $is_help
 */
class ArticleCategory extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    static public $status=[1=>'正常',0=>'隐藏',-1=>'删除'];
    
    static public $is_help=[1=>'是',0=>'否'];
    
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['sort', 'status', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '简介',
            'sort' => '排序',
            'status' => '状态',
            'is_help' => '类型(ishelp)',
        ];
    }
}
