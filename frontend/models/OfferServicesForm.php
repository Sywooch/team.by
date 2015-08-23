<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class OfferServicesForm extends Model
{
    public $email;
    public $email1;
	public $comment;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'comment'], 'required'],
            ['email', 'email'],
			[['comment'], 'string', 'min' => 3, 'max' => 255],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Ваш адрес электронной почты',
            'email1' => 'Адрес электронной почты',
            'comment' => 'Хочу добавить услугу',
            'verifyCode' => 'Результат капчи',
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
        return Yii::$app->mailer->compose('mail-offer-service', ['model'=>$this])
            ->setTo($email)
            ->setFrom(\Yii::$app->params['noreplyEmail'])
            ->setSubject('Предложение добавления услуги')
            ->send();
    }
}
