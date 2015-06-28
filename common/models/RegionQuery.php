<?php
namespace common\models;

use Yii;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class RegionQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}