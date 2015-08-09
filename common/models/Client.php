<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;

use yii\helpers\Html;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property integer $id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $info
 *
 * @property Order[] $orders
 */
class Client extends \yii\db\ActiveRecord
{
	//public $clientBackendUrlInner;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
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
            [['fio', 'phone'], 'required'],
			['phone', 'unique', 'targetClass' => \common\models\Client::className(), 'message' => 'Данный номер уже используется.'],
            [['fio', 'phone', 'email', 'info'], 'string', 'max' => 255]
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'info' => 'Дополнительная информация',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['client_id' => 'id']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['client_id' => 'id']);
    }
	
	
    public function getClientBackendUrl()
    {
        return Html::a($this->fio, ['client/update', 'id'=>$this->id], ['target'=>'_blank']);
    }
	
    public function getClientBackendUrlInner()
    {
        $res = Html::a($this->fio, ['client/update', 'id'=>$this->id]);
		return $res;
    }
}
