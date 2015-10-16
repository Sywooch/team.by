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
            'spec' => 'Специалист',
            'subject' => 'Тема',
            'comment' => 'Текст обращения',
            'status' => 'Status',
            'answer' => 'Текст ответа',
            'statusName' => 'Статус сообщения',
        ];
    }
	
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('mail-answer-to-spec', ['model'=>$this])
            ->setTo($email)
            ->setFrom(Yii::$app->params['noreplyEmail'])
            ->setSubject($this->subject)
            ->send();
    }
	

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
    public function getStatuses()
    {
        return [
            1 => 'Новое',
            2 => 'Отвечено',
        ];
    }	
	
    public function getStatusName()
    {
		return $this->statuses[$this->status];
    }
	
    /**
	* список новых сообщений
	*/
	public function getUnreadMessages()
    {
		return self::find()->where(['status'=>1])->all();
    }
	
}
