<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use yii\helpers\Url;
use yii\helpers\Html;

use common\models\Category;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_WAIT = 2;
	
	public $password;
	public $categoryUser;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
            //['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			
            ['username', 'required'],
            //['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
 
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255],
			
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
			
			['password', 'required', 'on' => 'create'],
			['password', 'string', 'min' => 6],
			
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'status' => 'Статус',
            'password' => 'Пароль',
            'userStatus' => 'Статус',
            'user_status' => 'Статус',
            'fio' => 'ФИО',
			
            'about' => 'Коротко о себе',
            'education' => 'Ваше образование',
            'experience' => 'Опыт работы',
            'price_list' => 'Вы можете загрузить прайс',
            'avatar' => 'Загрузите фото для анкеты',
            'region' => 'Город',
            'region_id' => 'Город',
            'region_parent_id' => 'Область',
            'region_name' => 'Город',
            'category1' => 'Выберите услуги',
            'price' => 'Стоимость работ',
            'awards' => 'Награды, димломы',
            'examples' => 'Примеры ваших работ',
            'to_client' => 'Осуществляем выезд к клиенту',
            'specialization' => 'Специализация',
            'license' => 'Лицензия',
			'user_type' => 'Тип деятельности',
			'license_checked' => 'Лицензия действительна до',
			'is_active' => 'Активность',
			'category_id' => 'Категория',
			'categoryUser' => 'Категория',
			
        ];
    }
	
    public function getStatusName()
    {
        $statuses = self::getStatusesArray();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }
 
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => 'Заблокирован',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_WAIT => 'Ожидает подтверждения',
        ];
    }	

    public function getUserStatus()
    {
        return $this->statusesArray[$this->user_status];
    }
	
    public function getUserStatuses()
    {
        return [
            0 => 'новый',
            1 => 'приостановлен',
            2 => 'требует проверки',
            10 => 'активен',
        ];
    }
    public function getUserStatusTxt()
    {
        return $this->userStatuses[$this->user_status];
    }
	
    public function getUserActivityList()
    {
        return [
            1 => 'Активен',
            0 => 'Неактивен',
        ];
    }
	
    public function getUserActivity()
    {
        return $this->userActivityList[$this->is_active];
    }
	
	
	

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	public function beforeSave($insert)
	{
		if ($this->isNewRecord)	{
			if($this->password)	$this->setPassword($this->password);
		}

		return parent::beforeSave($insert);
	}
		
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::className(), ['user_id' => 'id']);
    }
	
    public function getUserCategoriesArray()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->via('userCategories');
    }	
	
    public function getUserSpecials()
    {
        return $this->hasMany(UserSpecials::className(), ['user_id' => 'id']);
    }
	
    public function getUserMedia()
    {
        return $this->hasMany(UserMedia::className(), ['user_id' => 'id']);
    }
	
    public function getUserWeekend()
    {
        return $this->hasMany(UserWeekend::className(), ['user_id' => 'id']);
	}
	
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['user_id' => 'id']);
	}
	
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
	}
	
    public function getUserRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
	
    public function getNotifies()
    {
        return $this->hasMany(Notify::className(), ['user_id' => 'id']);
	}	
	
    public function getUnreadNotifies()
    {
        return $this->hasMany(Notify::className(), ['user_id' => 'id'])->where('readed = 0');
	}	
	
    public function getMedia()
    {
		$awards = [];
		$examples = [];
		foreach($this->userMedia as $media) {
			switch($media->media_id)	{
				case 1:
					$awards[] = $media->filename;
					break;
				case 2:
					$examples[] = $media->filename;
					break;
			}
		}
		return['awards'=>$awards, 'examples'=>$examples];
    }
	
    public function getFrontendUrl()
    {
        return \Yii::$app->urlManager->createUrl(['catalog/show', 'id' => $this->id]);
    }
	
    public function getAvatarUrl()
    {
        return Url::home(true).Yii::$app->params['avatars-path'].'/'.$this->avatar;
    }
	
    public function getAvatarThumbUrl()
    {
        return Url::home(true).Yii::$app->params['avatars-path'].'/thumb_'.$this->avatar;
    }
	
    public function getUserCategoriesList()
    {
		$html = '';
		foreach($this->userCategoriesArray as $row) {
			$html .= Html::tag('p', $row->name);
		}
        return $html;
    }
	
    public function getCategoryUser()
    {
		$user_categories = $this->userCategories;
		$category = Category::findOne($user_categories[0]->id);
		$parent = $category->parents(1)->one();
        return $parent->id;
    }
	
    public function getSpecBackendUrl()
    {
        if($this->id > 0) $url = Html::a($this->fio, ['spec/update', 'id'=>$this->id], ['target'=>'_blank']);
			else $url = 'Не указан';
		return $url;
    }
	
    public function getSpecBackendUrlInner()
    {
        if($this->id > 0) $url = Html::a($this->fio, ['spec/update', 'id'=>$this->id]);
			else $url = 'Не указан';
		return $url;
    }
	
	
}
