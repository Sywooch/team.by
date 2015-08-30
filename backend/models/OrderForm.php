<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Client;
use common\models\Order;
use common\models\Review;

use yii\helpers\ArrayHelper;

/**
 * RegStep1 form
 */
class OrderForm extends Model
{
    public $order_id = 0;
    public $client_id;
    public $category_id;
    public $user_id;
    public $created_at;
    public $date_control;
    public $control_note;
    public $descr;
    public $price1;
    public $price;
    public $fee;
    public $status;
    public $payment_status;
    public $review_status;
    public $review_state;
    
	
    public $fio;
    public $phone;
    public $email;
    public $info;
		
    public $review_text;
    public $review_rating;
    public $review_foto = [];
    public $youtube;
	public $answer_text;
	public $answer_status;
	
	public $pay_system;
	public $payed_at;
	public $tid;
	public $blocked;
	
	public $payment_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'descr', 'price1', 'category_id'], 'required'],
            [['review_rating'], 'required', 'on'=>'add_rating'],
            [['order_id', 'client_id', 'category_id', 'user_id', 'created_at', 'price1', 'price', 'fee', 'status', 'review_status', 'review_rating'], 'integer'],
            [['descr', 'review_text', 'date_control', 'payment_date', 'youtube'], 'string'],
			
            [['fio', 'phone'], 'required', 'on' => 'create'],
			['phone', 'unique', 'targetClass' => \common\models\Client::className(), 'message' => 'Данный номер уже используется.'],
            [['fio', 'phone', 'email', 'info', 'control_note', 'tid'], 'string', 'max' => 255],
			['email', 'email'],
			
			['review_foto', 'each', 'rule' => ['string']],
			
			[['review_text', 'answer_text'], 'string', 'min' => 3, 'max' => 2048],
			[['review_rating', 'review_state', 'answer_status', 'payment_status', 'pay_system', 'payed_at', 'blocked'], 'integer'],
			
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'client_id' => 'Клиент',
            'category_id' => 'Категория заявки',
            'user_id' => 'Исполнитель',
            'created_at' => 'Created At',
            'date_control' => 'Дата контроля',
            'control_note' => 'Заметка',
            'descr' => 'ИНформация о заказе',
            'price1' => 'Цена предварительная',
            'price' => 'Цена Окончательная',
            'fee' => 'Комисия',
            'status' => 'Статус заказа',
            'payment_status' => 'Статус оплаты',
            'review_status' => 'Статус отзыва',
            'review_state' => 'Состояние отзыва',
			
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'info' => 'Дополнительная информация',
			
            'review_text' => 'Текст отзыва',
            'review_foto' => 'Фото отзыва',
            'review_rating' => 'Оценка клиента',
            'youtube' => 'Видео отзыв',
			
            'answer_text' => 'Ответ специалиста',
            'answer_status' => 'Статус ответа',
            'blocked' => 'Заблокирован для оплаты',
            'payment_date' => 'Контроль оплаты',
			
        ];
    }
	
    public static function getStatuses()
    {
		return Order::getStatuses();
    }	
	
    public static function getPaymentStatuses()
    {
		return Order::getPaymentStatuses();
    }	
	
    public static function getReviewStatuses()
    {
        return Review::getReviewStatuses();
    }	
	
    public static function getReviewStates()
    {
		return Review::getReviewStates();
    }	
	
    public static function getAnswerStatuses()
    {
        return Review::getAnswerStatuses();
    }
	
    public static function getReviewRating()
    {
        return Review::getRatingList();
    }	
	
	
    public static function getBlockedList()
    {
        return Order::getBlockedList();
    }	
	
	
    public static function getClients()
    {
		$clients = \common\models\Client::find()->orderBy('fio')->all();		
		$clients = [0=>'Новый'] + ArrayHelper::map($clients, 'id', 'fio');
        return $clients;
    }
	
    public static function getUsers()
    {
		$users = \common\models\User::find()->where('group_id = 2 AND id > 0')->orderBy('fio')->all();
		$users = [-1=>'Не указан'] + ArrayHelper::map($users, 'id', 'fio');
        return $users;
    }
	
	public static function getCategories()
    {
		$categories = \common\models\Category::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		$categories1 = ArrayHelper::map($categories, 'id', 'name');
		
		$categories2 = [null=>'Выберите'];
		foreach($categories as $row) {
			if($row->parent_id != 1)
				$categories2[$categories1[$row->parent_id]][$row->id] = $row->name;
		}
		return $categories2;
    }	
	
    public function getPaySystemTxt()
    {
        switch($this->pay_system) {
			case 1:
				$res = 'Webpay';
				break;
			case 2:
				$res = 'ЕРИП IPay';
				break;			
			default:
				$res = 'Не уазано';
				break;
		}
		return $res;
    }	
	
	
}
