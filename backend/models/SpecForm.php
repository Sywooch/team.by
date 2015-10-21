<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

use yii\helpers\ArrayHelper;

/**
 * RegStep1 form
 */
class SpecForm extends User
{
	//public $licenseChecked
	
	public $regions = [];
	public $ratios = [];	
	
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['about', 'required'],
			['about', 'string', 'min' => 3, 'max' => 2048],

			['education', 'string', 'min' => 3, 'max' => 2048],
			
			[['phone'], 'string', 'min' => 19, 'max' => 19, 'tooShort'=>'Укажите номер в международном формате', 'tooLong'=>'Укажите номер в международном формате'],

			['experience', 'required'],
			['experience', 'string', 'min' => 3, 'max' => 2048],
			
			['specialization', 'string', 'min' => 3, 'max' => 256],
			
			
			[['license_checked', 'fio'], 'string'],	
			[['user_status', 'user_type', 'black_list'], 'integer'],
			
			['regions', 'each', 'rule' => ['integer']],
			['ratios', 'each', 'rule' => ['double']],
			['comment', 'string'],
			
        ];
    }
	
}

?>