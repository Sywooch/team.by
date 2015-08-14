<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ZakazSpec2 extends Model
{
    public $user_id;
    public $spec_name;
    public $name;
    //public $email = 'aldegtyarev@yandex.ru';
    public $email;
    public $email1;	// метка используется в письме
	public $phone;
	public $comment;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
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
            'name' => 'Имя',
            'phone' => 'Номер телефона',
            'comment' => 'Какой специалист нужен',
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
        return Yii::$app->mailer->compose('mail-zakaz-spec', ['model'=>$this])
            ->setTo($email)
            ->setFrom(\Yii::$app->params['noreplyEmail'])
            ->setSubject('Заявка на поиск специалиста')
            ->send();
    }
	
	/*
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setFrom('noreply@team.gf-club.net')
            ->setSubject('Заявка на поиск специалиста')
            ->setTextBody($this->comment)
            ->send();
    }
	*/
		
}
