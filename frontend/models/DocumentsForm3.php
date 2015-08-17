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
class DocumentsForm3 extends UserDocuments
{
    public $reg_file;
    public $license;
    public $bitovie_file;
    public $other_file = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['reg_file'], 'required'],
			[['reg_file','license', 'bitovie_file'], 'string', 'max' => 255],
			['other_file', 'each', 'rule' => ['string']],
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
            'bitovie_file' => 'Если оказываете бытовые услуги- подтверждение о нахождении в реестре бытовых услуг.',
            'other_file' => 'Другие документы (свидетельства о прохождении курсов, аттестаты)',
            //'' => '',
        ];
    }
}
