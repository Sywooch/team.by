<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Notify;


/**
 * RegStep1 form
 */
class NotifyForm extends Notify
{
    public $user_ids = [];
    public $msg;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['user_ids', 'each', 'rule' => ['integer']],
			[['msg'], 'string', 'min' => 3, 'max' => 2048],
			[['msg', 'user_id'], 'required'],
			
			
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg' => 'Текст сообщения',
        ];
    }
}
