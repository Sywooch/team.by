<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_to_administration}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $subject
 * @property string $comment
 * @property integer $status
 * @property string $answer
 *
 * @property User $user
 */
class UserToAdministration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_to_administration}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subject', 'comment'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['comment', 'answer'], 'string'],
            [['subject'], 'string', 'max' => 255]
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
            'subject' => 'Subject',
            'comment' => 'Comment',
            'status' => 'Status',
            'answer' => 'Answer',
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
