<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactToSpec extends Model
{
    public $name = 'alexey';
    public $phone = '375295379969';
    public $comment = 'Хочу муму';
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
			[['phone'], 'string', 'min' => 12, 'max' => 12],
			[['name'], 'string', 'min' => 3, 'max' => 255],
			[['comment'], 'string', 'min' => 3, 'max' => 255],
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
            'name' => 'ФИО',
            'phone' => 'Номер телефона',
            'comment' => 'Какого специалиста ищем?',
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
            ->setFrom('noreply@team.gf-club.net')
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
