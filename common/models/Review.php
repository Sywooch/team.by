<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

use yii\helpers\Html;

use yii\helpers\ArrayHelper; 

/**
 * This is the model class for table "{{%review}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $client_id
 * @property string $text
 *
 * @property ReviewMedia[] $reviewMedia
 */
class Review extends \yii\db\ActiveRecord
{
	
	public $review_foto = [];
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%review}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'client_id',  'user_id', 'review_text', 'review_rating'], 'required'],
            [['order_id', 'client_id', 'user_id', 'review_rating', 'answer_status', 'status'], 'integer'],
            [['review_text', 'youtube', 'answer_text'], 'string'],
			['review_foto', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Заказ',
            'client_id' => 'Клиент',
            'user_id' => 'Исполнитель',
            
			'status' => 'Статус отзыва',
			'review_text' => 'Текст отзыва',
            'review_rating' => 'Оценка',			
            'review_foto' => 'Фото',
            'youtube' => 'Видео',
			
            'answer_text' => 'Текст ответа',
            'answer_status' => 'Статус ответа',
            
			
            'client' => 'Клиент',
            'user' => 'Исполнитель', 
            'order' => 'Заказ',
			
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewMedia()
    {
        return $this->hasMany(ReviewMedia::className(), ['review_id' => 'id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
	
    public function getReviewBackendUrl()
    {
        return Html::a($this->id, ['review/update', 'id'=>$this->id]);
    }
	
    public function getOrders()
    {
		//убираем заказы на которые отзывы уже оставлены
		$orders = \common\models\Order::find()->orderBy('id DESC')->all();
		$reviews = $this->find()->all();
		foreach($orders as $k=>$order) {
			foreach($reviews as $review) {
				if($order->id == $review->order_id && $order->id != $this->order_id)
					unset($orders[$k]);
			}
		}
		//echo count($orders);
		$orders = ArrayHelper::map($orders, 'id', 'id');
        return $orders;
    }
	
    public function getClients()
    {
		$clients = \common\models\Client::find()->orderBy('fio')->all();		
		$clients = ArrayHelper::map($clients, 'id', 'fio');
        return $clients;
    }
	
    public function getUsers()
    {
		$users = \common\models\User::find()->where('group_id = 2 AND id > 0')->orderBy('fio')->all();
		$users = ArrayHelper::map($users, 'id', 'fio');
        return $users;
    }
	
	public function getRatingList()
	{
        return [
            1 => '1-очень плохо',
            2 => '2-плохо',
            3 => '3-удовлетворительно',
            4 => '4-хорошо',
            5 => '5-отлично',
        ];
	}
	
    public static function getReviewStates()
    {
        return [
            0 => 'Требует модерации',
            1 => 'Опубликован',
        ];
    }
	
    public static function getAnswerStatuses()
    {
        return [
            0 => 'Новый',
            1 => 'Одобрен',
            2 => 'Удален',
        ];
    }
	
    public static function getReviewStatuses()
    {
		return [
            1 => 'Ожидание',
            2 => 'Получен',
            3 => 'Отказано',
        ];
    }	
	
}
