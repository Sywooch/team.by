<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_weekend}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $weekend
 *
 * @property User $user
 */
class UserWeekend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_weekend}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'weekend'], 'required'],
            [['user_id'], 'integer'],
            [['weekend'], 'integer']
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
            'weekend' => 'Weekend',
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
