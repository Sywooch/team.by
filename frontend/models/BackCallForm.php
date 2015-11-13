<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class BackCallForm extends Model
{
//    public $name = 'alexey';
//    public $phone = '375295379969';
//    public $comment = 'Хочу муму';

    public $name;
    public $phone = '';
    public $verifyCode;
    
    public $name1;
    public $phone1;
    public $country_code = 'by';
    
    //public $comment;
    //public $user_id = 0;
	//public $spec_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required', 'message'=>'Укажите номер телефона'],
            [['name'], 'required', 'message'=>'Укажите Ваше имя'],
			//[['phone'], 'string', 'min' => 19, 'max' => 19, 'tooShort'=>'Укажите номер в международном формате', 'tooLong'=>'Укажите номер в международном формате'],
			[['phone'], 'string', 'max' => 19, 'tooLong'=>'Укажите номер в международном формате'],
			[['name',], 'string', 'min' => 3, 'max' => 255],
			[['country_code'], 'string', 'min' => 2, 'max' => 4],
            ['verifyCode', 'captcha'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'phone' => 'Ваш номер телефона',
            'name1' => 'Имя',
            'phone1' => 'Номер телефона',
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
        return Yii::$app->mailer->compose('mail-back-call', ['model'=>$this])
            ->setTo($email)
            //->setTo("aldegtyarev@yandex.ru")
            ->setFrom(\Yii::$app->params['noreplyEmail'])
            ->setSubject('Заявка на обратный звонок')
            ->send();
    }
    
}
