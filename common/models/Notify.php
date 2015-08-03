<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user_notify}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $msg
 * @property integer $readed
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notify}}';
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
            [['user_id', 'msg'], 'required'],
            [['user_id', 'readed'], 'integer'],
			[['msg'], 'string', 'min' => 3, 'max' => 2048],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'msg' => 'Msg',
            'readed' => 'Readed',
        ];
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
}
