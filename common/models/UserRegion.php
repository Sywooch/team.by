<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_region}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $region_id
 *
 * @property User $user
 * @property Region $region
 */
class UserRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'region_id'], 'required'],
            [['user_id', 'region_id'], 'integer'],
            [['ratio'], 'double'],
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
            'region_id' => 'Region ID',
            'ratio' => 'Ratio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
