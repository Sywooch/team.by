<?php
namespace common\models;
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ZakazSpec1 extends Model
{
//    public $name = 'alexey';
//    public $phone = '375295379969';
//    public $comment = 'Хочу муму';

    public $name;
    public $phone;
    public $comment;
    public $user_id;
	public $spec_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'user_id'], 'required'],
			['phone', 'string', 'min' => 12, 'tooShort'=>'Неверный номер телефона'],
			[['name', 'spec_name'], 'string', 'min' => 3, 'max' => 255],
			[['comment'], 'string', 'min' => 3, 'max' => 255],
			['user_id', 'integer'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'phone' => 'Ваш номер телефона',
            'comment' => 'Какой специалист вам нужен?',
        ];
    }
}
