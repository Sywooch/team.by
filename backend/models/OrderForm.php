<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Client;
use common\models\Order;

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
	public $answer_text;
	public $answer_status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'descr', 'price1', 'category_id'], 'required'],
            [['order_id', 'client_id', 'category_id', 'user_id', 'created_at', 'price1', 'price', 'fee', 'status', 'review_status'], 'integer'],
            [['descr', 'review_text', 'date_control'], 'string'],
			
            [['fio', 'phone'], 'required', 'on' => 'create'],
			['phone', 'unique', 'targetClass' => \common\models\Client::className(), 'message' => 'Данный номер уже используется.'],
            [['fio', 'phone', 'email', 'info', 'control_note'], 'string', 'max' => 255],
			['email', 'email'],
			
			['review_foto', 'each', 'rule' => ['string']],
			
			[['review_text', 'answer_text'], 'string', 'min' => 3, 'max' => 2048],
			[['review_rating', 'review_state', 'answer_status', 'payment_status'], 'integer'],
			
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
            'answer_text' => 'Ответ специалиста',
            'answer_status' => 'Статус ответа',
			
        ];
    }
	
    public static function getStatuses()
    {
        return [
            1 => 'новый',
            2 => 'в работе',
            3 => 'выполнен',
            4 => 'оплачен',
            5 => 'отзыв получен',
            6 => 'заказ закрыт',
        ];
    }	
	
    public static function getPaymentStatuses()
    {
        return [
            1 => 'ожидает оплаты',
			2 => 'просрочен',
            10 => 'оплачен',
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
            2 => 'Удалён',
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
	
	
	
}
