<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $parent_id
 * @property integer $popular
 * @property string $name
 * @property string $s_descr
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_descr
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'parent_id', 'popular'], 'integer'],
            [['lft', 'rgt', 'depth', 'parent_id', 'name', 's_descr', 'description', 'meta_title', 'meta_keyword', 'meta_descr'], 'required'],
            [['description', 'meta_descr'], 'string'],
            [['name', 's_descr', 'meta_title', 'meta_keyword'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'parent_id' => 'Parent ID',
            'popular' => 'Popular',
            'name' => 'Name',
            's_descr' => 'S Descr',
            'description' => 'Description',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_descr' => 'Meta Descr',
        ];
    }
}
