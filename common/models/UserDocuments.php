<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_documents}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $document_id
 * @property string $filename
 *
 * @property User $user
 */
class UserDocuments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_documents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'document_id', 'filename'], 'required'],
            [['user_id', 'document_id'], 'integer'],
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
            'document_id' => 'Document ID',
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
