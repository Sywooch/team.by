<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%review_media}}".
 *
 * @property integer $id
 * @property integer $review_id
 * @property string $filename
 *
 * @property Review $review
 */
class ReviewMedia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%review_media}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review_id', 'filename'], 'required'],
            [['review_id'], 'integer'],
            [['filename'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'review_id' => 'Review ID',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id' => 'review_id']);
    }
}
