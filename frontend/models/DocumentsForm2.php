<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
//use common\models\User;
use common\models\UserDocuments;



// https://github.com/2amigos/yii2-date-picker-widget
// http://bootstrap-datepicker.readthedocs.org/en/release/

/**
 * Signup form
 */
class DocumentsForm2 extends UserDocuments
{
    public $reg_file;
    public $license = '';
    public $bitovie_file;
    public $attestat_file;
    public $contact_fio = '';
    public $contact_phone = '+375';
    public $contact_dolj = '';
    public $contact_osn = '';
    //public $other_file = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['reg_file','contact_fio', 'contact_phone', 'contact_dolj', 'contact_osn'], 'required'],
			['contact_fio', 'validateFio'],
			[['reg_file','license', 'bitovie_file', 'attestat_file', 'contact_fio', 'contact_dolj', 'contact_osn'], 'string', 'max' => 255],
			[['contact_phone'], 'string', 'min' => 13, 'tooShort'=>'Укажите номер в международном формате', 'tooLong'=>'Укажите номер в международном формате'],
			//['other_file', 'each', 'rule' => ['string']],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reg_file' => 'Свидетельство о гос.регистрации',
            'license' => 'Если лицензируемый вид деятельности – лицензия, выданная уполномоченными органами',
            'bitovie_file' => 'Если оказываете бытовые услуги- подтверждение о нахождении в реестре бытовых услуг',
            'attestat_file' => 'Если оказываете услуги в строительстве – свидетельство об аттестации',
			 'contact_fio' => 'ФИО',
			 'contact_phone' => 'Телефон',
			 'contact_dolj' => 'Должность',
			 'contact_osn' => 'На основании чего имеет право заключить договор публичной оферты (доверенность, устав)',
            //'other_file' => 'Другие документы (свидетельства о прохождении курсов, аттестаты)',
            //'' => '',
        ];
    }
	
    public function validateFio($attribute, $params)
    {
		if (!$this->hasErrors()) {
			$fio_arr = explode(' ', $this->contact_fio);
			if(count($fio_arr) != 3)
				$this->addError($attribute, 'Укажите полностью ваше ФИО');
		}
    }
	
}
