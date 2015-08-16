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

			['experience', 'required'],
			['experience', 'string', 'min' => 3, 'max' => 2048],
			
			
			[['license_checked', 'fio'], 'string'],	
			[['user_status', 'region_id', 'user_type', 'black_list'], 'integer'],
			
			['regions', 'each', 'rule' => ['integer']],
			['ratios', 'each', 'rule' => ['double']],
			
        ];
    }
	
}

?>