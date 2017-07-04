<?php

namespace backend\models;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $label
 * @property string $url
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const SCENARIO_ADD = 'add';

    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['url'], 'string', 'max' => 30],
            [['parent_id','name'],'required'],
            ['name','unique','on'=>self::SCENARIO_ADD],
            ['url','unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '父类ID',
            'name' => '名称',
            'url' => '地址/路由',
            'sort'=>'排序'
        ];
    }

    public function behaviors() {
        return [
            'tree' => [
                'class'=>NestedSetsBehavior::className(),

                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public function getChildren()
    {
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}
