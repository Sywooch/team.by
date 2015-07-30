<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */

// https://stand.besmart.by:4443/pls/ipay/!iSOU.Login

// srv_no=123
class IpayForm extends Model
{
    public $srv_no;
    public $pers_acc;
    public $amount;
    public $amount_editable;
    public $provider_url; 

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        ];
    }

}
