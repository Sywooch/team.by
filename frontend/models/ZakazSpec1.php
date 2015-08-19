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
    public $phone = '+375';
    public $comment;
    public $user_id = 0;
	public $spec_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'user_id'], 'required'],
			[['phone'], 'string', 'min' => 13, 'tooShort'=>'Укажите номер в международном формате', 'tooLong'=>'Укажите номер в международном формате'],
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
