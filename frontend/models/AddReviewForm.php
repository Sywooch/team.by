<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class AddReviewForm extends Model
{

    public $name;
    public $phone;
    public $user_id;
    public $foto = [];
	
    public $video;
    public $comment;
    public $rating;

	
	/*
    public $name = 'aad';
    public $phone = '375 44 897 12 64';
    public $user_id;
    public $foto = ['29296c291937f747bebd20e2acd087dd.jpg'];
	
    public $video = 'http://ya.com';
    public $comment = 'С другой стороны рамки и место обучения кадров в значительной степени обуславливает создание форм развития. ';
    public $rating = 4;
	*/
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['user_id', 'rating'], 'integer'],
            [['user_id'], 'required', 'message'=>'Выберите исполнителя'],
            [['rating'], 'required', 'message'=>'Укажите вашу оценку'],
			
			[['phone'], 'required'],
			[['phone'], 'string', 'min' => 12],
			
			[['name'], 'string', 'min' => 3, 'max' => 255],
			
			[['video'], 'url', 'message'=> 'Введите корректный URL'],
			
			[['comment'], 'required', 'message'=>'Напишите свой отзыв'],
			[['comment'], 'string', 'min' => 3, 'max' => 1024],
			
			['foto', 'each', 'rule' => ['string']],
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
			'user_id' => 'Специалист',
            'foto' => 'Загрузите фото работы (форматы gif, png, jpeg)',
            'video' => 'Ссылка на видео в youtube.com',
            'rating' => 'Оцените работу',
            'comment' => 'Напишите свой отзыв',
        ];
    }
	
    public static function getReviewRating()
    {
        return [
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
        ];
    }
	
    public function getUserList()
    {
		if($this->phone != '')	{
			$client = \common\models\Client::find()->where(['phone' => $this->phone])->one();
			if($client !== NULL)	{
				$orders = $client->orders;

				$users = \common\models\User::find()
						->distinct(true)
						->joinWith(['orders'])
						->where(['{{%order}}.client_id'=>$client->id])
						->all();
				
				$users_arr = [null => '--- Выберите ----'] + ArrayHelper::map($users, 'id', 'fio');
				
			}	else	{
				$users_arr = [null => '--- Введите сначала ваш номер телефона ----'];
			}
		}	else	{
			$users_arr = [null => '--- Введите сначала ваш номер телефона ----'];
		}
	
		
		
        return $users_arr;
    }
	
}
