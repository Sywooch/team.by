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
    public $descr;
    public $price1;
    public $price;
    public $fee;
    public $status;
    public $payment_status;
    public $review_status;
	
    public $fio;
    public $phone;
    public $email;
    public $info;
		
    public $review_text;
    public $review_rating;
    public $review_foto = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'descr', 'price1'], 'required'],
            [['order_id', 'client_id', 'category_id', 'user_id', 'created_at', 'price1', 'price', 'fee', 'status', 'review_status'], 'integer'],
            [['descr', 'review_text', 'date_control'], 'string'],
			
            [['fio', 'phone'], 'required', 'on' => 'create'],
			['phone', 'unique', 'targetClass' => \common\models\Client::className(), 'message' => 'Данный номер уже используется.'],
            [['fio', 'phone', 'email', 'info'], 'string', 'max' => 255],
			['email', 'email'],
			
			['review_foto', 'each', 'rule' => ['string']],
			['review_text', 'string', 'min' => 3, 'max' => 2048],
			['review_rating', 'integer'],
			
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
            'descr' => 'ИНформация о заказе',
            'price1' => 'Цена предварительная',
            'price' => 'Цена Окончательная',
            'fee' => 'Комисия',
            'status' => 'Статус',
            'payment_status' => 'Статус оплаты',
            'review_status' => 'Статус отзыва',
			
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'info' => 'Дополнительная информация',
			
            'review_text' => 'Текст отзыва',
            'review_foto' => 'Фото отзыва',
            'review_rating' => 'Оценка клиента',
			
        ];
    }
	
    public static function getStatuses()
    {
        return [
            1 => 'в работе',
            2 => 'выполнен и оплачен',
            3 => 'завершен',
        ];
    }	
	
    public static function getPaymentStatuses()
    {
        return [
            1 => 'ожидает оплаты',
            2 => 'оплачен',
            3 => 'просрочен',
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
