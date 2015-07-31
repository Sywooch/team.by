<?php
namespace frontend\models;

use Yii;

use yii\helpers\ArrayHelper;

use common\models\User;

/**
 * RegStep1 form
 */
class ProfilePaymentTypeForm extends User
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['payment_type'], 'integer'],
			['payment_type', 'required'],
			
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'payment_type' => 'Метод оплаты',
            //'' => '',
        ];
    }

	protected function getPaymentsList()
    {
		return [
			1 => 'Webpay',
			2 => 'IPay'
		];
    }
}
