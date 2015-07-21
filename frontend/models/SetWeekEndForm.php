<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

class SetWeekEndForm extends Model
{
    public $weekends;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['weekends'], 'required'],
            ['weekends', 'string', 'max' => 1024],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'' => '',
        ];
    }	
}
