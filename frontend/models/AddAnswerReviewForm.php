<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class AddAnswerReviewForm extends \common\models\Review
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['answer_text', 'required'],
            ['answer_text', 'string', 'min' => 5, 'max' => 1024],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'answer_text' => 'Ваш ответ',            
        ];
    }
	

}
