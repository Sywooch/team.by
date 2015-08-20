<?php
namespace common\models;
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * RegStep1 form
 */
class RegStep1Form extends Model
{
    public $user_type;
    public $fio;
    public $email;
    public $phone = '+375';
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
			['fio', 'validateFio'],
 
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => \common\models\User::className(), 'message' => 'Данный email уже используется.'],
            ['email', 'string', 'max' => 255],
			
			['phone', 'required'],
            [['phone'], 'string', 'min' => 19, 'max' => 19, 'tooShort'=>'Укажите номер в международном формате', 'tooLong'=>'Укажите номер в международном формате'],
 									
			[['password', 'passwordRepeat'], 'required'],
			[['password', 'passwordRepeat'], 'string', 'min' => 6],
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
	
    public function validateFio($attribute, $params)
    {
		if (!$this->hasErrors()) {
			$fio_arr = explode(' ', $this->fio);
			if(count($fio_arr) != 3)
				$this->addError($attribute, 'Укажите полностью ваше ФИО');
		}
    }
	
}
