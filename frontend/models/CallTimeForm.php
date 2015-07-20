<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

// https://github.com/2amigos/yii2-date-picker-widget
// http://bootstrap-datepicker.readthedocs.org/en/release/

/**
 * Signup form
 */
class CallTimeForm extends Model
{
    public $call_from;
    public $call_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['call_from', 'call_to'], 'required'],
            [['call_from', 'call_to'], 'integer'],
			['call_from', 'compareCallTo'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'call_from' => 'С',
            'call_to' => 'До',
            //'' => '',
        ];
    }
	
    /**
     * @param string $attribute
     * @param array $params
     */
    public function compareCallTo($attribute, $params)
    {
        /*
		if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Введите корректное время звонков');
            }
        }
		*/
    }	
	
	
	public function getCallHours()
	{
		$hours = [];
		for ($x = Yii::$app->params['call_time_from']; $x <= Yii::$app->params['call_time_to']; $x++) {
			$value = $x.':00';
			$hours[$x] = $value;
		}
		return $hours;
		//print_r($hours);die;
	}
}
