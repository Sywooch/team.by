<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

use yii\helpers\Html;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $category_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $date_control
 * @property string $info
 * @property integer $price1
 * @property integer $price
 * @property integer $status
 * @property string $review_text
 * @property integer $review_status
 *
 * @property User $user
 * @property Client $client
 * @property Category $category
 */
class Order extends \yii\db\ActiveRecord
{
	
	//public $orderStatusTxt;
		
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
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
            [['client_id', 'descr', 'price1'], 'required'],
            [['client_id', 'category_id', 'user_id', 'created_at', 'date_control', 'price1', 'price', 'fee', 'status', 'review_status'], 'integer'],
            [['descr', 'payment_date'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'clientName' => 'Клиент',
            'category_id' => 'Category ID',
            'user_id' => 'Исполнитель',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'date_control' => 'Дата контроля',
            'descr' => 'ИНформация о заказе',
            'price1' => 'Цена предварительная',
            'price' => 'Цена Окончательная',
			'fee' => 'Комисия',
            'status' => 'Статус',
            //'review_text' => 'Review Text',
            'review_status' => 'Статус отзыва',
			'client' => 'Клиент',
			'user' => 'Исполнитель',
			'control_note' => 'Заметка',
			'orderStatusTxt' => 'Статус заказа',
			'payInfo' => 'Оплата',
        ];
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
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::className(), ['order_id' => 'id']);
    }	
	
    public function getClientName()
    {
        return $this->client->fio;
    }
	
    public function getOrderPaymentStatusClass()
    {
        switch($this->payment_status) {
			case 1:
				$res = 'order_status_wait';
				break;
			case 2:
				$res = 'order_status_warning';
				break;			
			case 10:
				$res = 'order_status_ok';
				break;
			default:
				$res = 'order_status_wait';
				break;
		}
		return $res;
    }
	
    public static function getBlockedList()
    {
        return [
            0 => 'Нет',
            1 => 'Да',
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
	
    public function getOrderPaymentStatusTxt()
    {
		return $this->paymentStatuses[$this->payment_status];
    }
	
    public static function getStatuses()
    {
        return [
            1 => 'новый',
            2 => 'в работе',
            3 => 'выполнен',
            4 => 'оплачен, ожидает отзыва',
            5 => 'отзыв получен',
            6 => 'заказ закрыт',
        ];
    }	
	
    public function getOrderStatusTxt()
    {
		return $this->statuses[$this->status];
    }
	
	public function getPayInfo()
	{
		$text = '';
		switch($this->pay_system) {
			case 1:
				$text .= 'WebPay';
				break;
			case 2:
				$text .= 'ЕРИП';
				break;
			default:
				$text .= 'n/a';
				break;
		}
		
		$text .= ' №'.$this->tid . '<br>';
		$text .= Yii::$app->formatter->asDate($this->payed_at, 'php:d-m-yy H:i');;
		return $text;
	}
	
    public function getOrderBackendUrl()
    {
        return Html::a($this->id, ['order/update', 'id'=>$this->id]);
    }
	
}
