<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_descr
 */
class Category extends \yii\db\ActiveRecord
{
	
	public $parent_id_old = 0;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'parent_id', 'popular'], 'integer'],
            [['name'], 'required'],
            [['description', 'meta_descr', 's_descr'], 'string'],
            [['name', 'alias', 'meta_title', 'meta_keyword', 's_descr'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'parent_id' => 'Родитель',
            'popular' => 'Популярная',
            'name' => 'Название категории',
            'alias' => 'Псевдоним',
            's_descr' => 'Текстовая подпись',
            'description' => 'Описание',
            'meta_title' => 'Meta Title',
            'meta_keyword' => 'Meta Keyword',
            'meta_descr' => 'Meta Descr',
        ];
    }
	
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
	
	/**
	 * Транслит
	 * @param $text
	 * @return string
	 */
	public static function ToTranslit($text)
	{
		$find=array('А','а','Б','б','В','в','Г','г','Д','д','Е','е','Ё','ё',
			'Ж','ж','З','з','И','и','Й','й','К','к','Л','л','М','м',
			'Н','н','О','о','П','п','Р','р','С','с','Т','т','У','у',
			'Ф','ф','Х','х','Ц','ц','Ч','ч','Ш','ш','Щ','щ','Ъ','ъ',
			'Ы','ы','Ь','ь','Э','э','Ю','ю','Я','я', '№',' ');

		$replace=array('A','a','B','b','V','v','G','g','D','d','E','e','Yo','yo',
			'Zh','zh','Z','z','I','i','J','j','K','k','L','l','M','m',
			'N','n','O','o','P','p','R','r','S','s','T','t','U','u','F',
			'f','H','h','Ts','ts','CH','ch','Sh','sh','Sch','sch',
			'','','Y','y','','','E','e','Yu','yu','Ya','ya', '',' ');

	   return preg_replace('/[^\w\d\s_-]*/','',str_replace($find,$replace,$text));
	}	
	
	/*
	public function save($runValidation = true, $attributeNames = null)
	{
		//echo'<pre>';print_r($this->attributes);echo'<pre>';die;
		if ($this->getIsNewRecord()) {
			if($this->parent_id == 0) {
				$this->makeRoot();
			}	else	{
				$parent_category = Category::find()->where(['id' => $this->parent_id])->one();
				$this->appendTo($parent_category);
			}
			return $this->insert($runValidation, $attributeNames);
		} else {
			return $this->update($runValidation, $attributeNames) !== false;
		}		
		//return true;
	}
	*/
	
	/*
	public function beforeSave($insert)
	{
		//echo'<pre>';print_r($this->attributes);echo'<pre>';die;
		if ($this->isNewRecord)	{
			if($this->parent_id == 0) {
				$this->makeRoot();
			}	else	{
				$parent_category = Category::find()->where(['id' => $this->parent_id])->one();
				$this->appendTo($parent_category);
			}
		}

		return parent::beforeSave($insert);
	}	
	*/
	

	public function afterSave($insert, $changedAttribute)
	{
		//echo'<pre>';print_r($this->attributes);echo'<pre>';die;
		if ($this->path == '')	{
			$parents = $this->parents()->all();
			$aliases = [];
			foreach($parents as $p) {
				if($p->id != 1) $aliases[] = $p->alias;
			}
				
			$aliases[] = $this->alias;
			$this->path = implode('/', $aliases);
			$this->save(false);
			
		}

		//return parent::afterSave($insert);
	}	
	
	
}
