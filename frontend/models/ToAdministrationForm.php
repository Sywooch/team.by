<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ToAdministrationForm extends Model
{
    public $subject;
    public $subject1;
    public $body;
    public $body1;
    public $fio;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subject', 'body'], 'required'],
			[['subject'], 'string', 'min' => 7],
			[['body'], 'string', 'min' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subject' => 'Введите тему сообщения',
            'subject1' => 'Тема сообщения',
            'body' => 'Введите ваше сообщение',
            'body1' => 'Сообщение',
            'fio' => 'Специалист',
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
        return Yii::$app->mailer->compose('mail-to-administration', ['model'=>$this])
            ->setTo($email)
            ->setFrom('noreply@team.gf-club.net')
            ->setSubject('Внутреннее сообщение от специалиста')
            ->send();
    }
}
