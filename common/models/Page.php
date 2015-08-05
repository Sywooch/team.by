<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

use backend\helpers\DAliasHelper;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
	

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['text'], 'string'],
            [['name', 'alias'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Страница',
            'text' => 'Текст',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'alias' => 'Alias',
        ];
    }
	
	
	public function beforeSave($insert)
	{
		/*
		//echo'<pre>';print_r($this->attributes);echo'<pre>';die;
		if ($this->isNewRecord)	{
			if($this->parent_id == 0) {
				$this->makeRoot();
			}	else	{
				$parent_category = Category::find()->where(['id' => $this->parent_id])->one();
				$this->appendTo($parent_category);
			}
		}
		*/
		if($this->alias == '') DAliasHelper::setAlias($this);

		return parent::beforeSave($insert);
	}	
	
	
}
