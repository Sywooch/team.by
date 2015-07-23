<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

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
            [['descr', 'review_text'], 'string']
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
            'created_at' => 'Created At',
            'date_control' => 'Дата контроля',
            'descr' => 'ИНформация о заказе',
            'price1' => 'Цена предварительная',
            'price' => 'Цена Окончательная',
			'fee' => 'Комисия',
            'status' => 'Статус',
            'review_text' => 'Review Text',
            'review_status' => 'Статус отзыва',
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
	
    public function getClientName()
    {
        return $this->client->fio;
    }
	
}
