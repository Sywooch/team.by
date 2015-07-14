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
    public $name;
    public $phone;
    public $comment;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone'], 'required'],
			[['phone'], 'string', 'min' => 12, 'max' => 12],
			[['name'], 'string', 'min' => 3, 'max' => 255],
			[['comment'], 'string', 'min' => 3, 'max' => 255],
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
