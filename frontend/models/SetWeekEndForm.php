<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

class SetWeekEndForm extends Model
{
    public $weekedns;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['weekedns'], 'required'],
            ['weekedns', 'string', 'max' => 1024],
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
