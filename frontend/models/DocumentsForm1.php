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
class DocumentsForm1 extends UserDocuments
{
    public $passport_num;
    public $passport_vidan;
    public $passport_expire;
    public $passport_file;
    public $trud_file;
    public $diplom_file;
    public $other_file = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['passport_num', 'passport_vidan', 'passport_expire'], 'required'],
			[['passport_num', 'passport_vidan', 'passport_expire', 'passport_file','trud_file', 'diplom_file'], 'string', 'max' => 255],
			['other_file', 'each', 'rule' => ['string']],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passport_num' => 'Номер паспорта',
            'passport_vidan' => 'Выдан',
            'passport_expire' => 'Действителен до',
            'passport_file' => 'Копия паспорта',
            'trud_file' => 'Копия трудовой книжки, подтверждающая стаж работы по профессии',
            'diplom_file' => 'Копия диплома о высшем/среднем специальном образовании',
            'other_file' => 'Другие документы (свидетельства о прохождении курсов, аттестаты)',
            //'' => '',
        ];
    }
}
