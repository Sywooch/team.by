<?php

namespace common\models;

use Yii;

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
    public function rules()
    {
        return [
            [['order_id', 'client_id',  'user_id', 'review_text', 'review_rating'], 'required'],
            [['order_id', 'client_id', 'user_id', 'review_rating'], 'integer'],
            [['review_text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'client_id' => 'Client ID',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewMedia()
    {
        return $this->hasMany(ReviewMedia::className(), ['review_id' => 'id']);
    }
}
