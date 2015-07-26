<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property integer $id
 * @property integer $num_code
 * @property string $char_code
 * @property string $name
 * @property double $rate
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
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
            [['num_code', 'char_code', 'name', 'rate'], 'required'],
            [['num_code'], 'integer'],
            [['rate'], 'number'],
            [['char_code'], 'string', 'max' => 4],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_code' => 'Код валюты по ISO',
            'char_code' => 'Символьный код',
            'name' => 'Название',
            'rate' => 'Курс',
            'updated_at' => 'Обновлён',
        ];
    }
}
