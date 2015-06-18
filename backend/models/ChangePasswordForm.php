<?php
namespace app\models;
 
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
 
/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
    public $newPassword;
    public $newPasswordRepeat;
 
    /**
     * @var User
     */
    private $_user;
 
    /**
     * @param User $user
     * @param array $config
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(User $user, $config = [])
    {
        if (empty($user)) {
            throw new InvalidParamException('User is empty.');
        }
        $this->_user = $user;
        parent::__construct($config);
    }
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newPassword', 'newPasswordRepeat'], 'required'],
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => Yii::t('app', 'Новый пароль'),
            'newPasswordRepeat' => Yii::t('app', 'Повтор пароля'),
        ];
    }
 
    /**
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, Yii::t('app', 'ERROR_WRONG_CURRENT_PASSWORD'));
            }
        }
    }
 
    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPassword);
            return $user->save();
        } else {
            return false;
        }
    }
}