<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_media}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $media_id
 * @property string $filename
 *
 * @property User $user
 */
class UserMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'media_id', 'filename'], 'required'],
            [['user_id', 'media_id'], 'integer'],
            [['filename'], 'string', 'max' => 255]
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
            'media_id' => 'Media ID',
            'filename' => 'Filename',
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
