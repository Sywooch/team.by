<?php
namespace common\models;
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * RegStep1 form
 */
class RegStep1Form extends Model
{
    public $user_type;
    public $fio;
    public $email;
    public $phone;
    public $password;
    public $passwordRepeat;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			['user_type', 'required', 'message' => 'Укажите вид вашей деятельности.'],
			[['user_type'], 'integer'],
			
			['fio', 'required'],
            ['fio', 'string', 'min' => 7, 'max' => 255],
 
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'Данный email уже используется.'],
            ['email', 'string', 'max' => 255],
			
			['phone', 'required'],
            ['phone', 'string', 'min' => 7, 'max' => 255],
 									
			['password, passwordRepeat', 'required'],
			['password, passwordRepeat', 'string', 'min' => 6],
			['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_type' => 'Выберите тип деятельности',
            'fio' => 'Ваша фамилия, имя и отчество',
            'email' => 'Ваша электронная почта',
            'phone' => 'Ваш номер телефона',
            'password' => 'Ваш пароль',
            'passwordRepeat' => 'Повторите пароль',
            //'' => '',
        ];
    }
}
