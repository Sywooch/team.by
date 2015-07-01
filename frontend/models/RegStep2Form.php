<?php
namespace common\models;
namespace frontend\models;

use Yii;
use yii\base\Model;

use yii\helpers\ArrayHelper;

use common\models\Region;



/**
 * RegStep1 form
 */
class RegStep2Form extends Model
{
    public $region = 4;	// 4 - это ИД Минска
    public $about;
    public $education;
    public $experience;
    public $price_list;
    public $avatar;
    public $region_parent_id = 2; // 2 - это ИД Минской области
    public $region_name;
    public $categories;
    //public $awards = [];
    //public $examples = [];



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['region', 'region_parent_id'], 'integer'],
			
			['about', 'required'],
            ['about', 'string', 'min' => 3, 'max' => 2048],
            
			['education', 'string', 'min' => 3, 'max' => 2048],
            
			['experience', 'required'],
			['experience', 'string', 'min' => 3, 'max' => 2048],
			
            ['price_list', 'string', 'min' => 3, 'max' => 255],
			
			['avatar', 'required'],
            ['avatar', 'string', 'min' => 3, 'max' => 255],
			
            ['region_name', 'string', 'min' => 3, 'max' => 255],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'about' => 'Коротко о себе',
            'education' => 'Ваше образование',
            'experience' => 'Опыт работы',
            'price_list' => 'Вы можете загрузить прайс',
            'avatar' => 'Загрузите фото для анкеты',
            'region' => 'Город',
            'region_parent_id' => 'Область',
            'region_name' => 'Город',
            //'' => '',
            //'' => '',
        ];
    }
	
    //получает список категорий для выпадающего списка
	//с группировкой по областям
	protected function getRegionsDropDownList()
    {
		$categories = Region::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		$categories1 = ArrayHelper::map($categories, 'id', 'name');
		//print_r($categories[2]->parent_id);
		
		$categories2 = [];
		foreach($categories as $row) {
			if($row->parent_id != 1)
				$categories2[$categories1[$row->parent_id]][$row->id] = $row->name;
				//$categories2[] = ['id'=>$row->id, 'text'=>$row->name, 'group'=>$categories1[$row->parent_id]];
		}
		
		//echo'<pre>';print_r($categories1);echo'</pre>';
		//echo'<pre>';print_r($categories2);echo'</pre>';
		
		$categories = $categories2;
		return $categories;
    }
	
	//получает список категорий первого уровня для выпадающего списка
	protected function getRegionsLevel1DropDownList()
    {
		$categories = Region::find()->where('id <> 1 AND depth = 1')->orderBy('lft, rgt')->all();
		$categories = ArrayHelper::map($categories, 'id', 'name');
		return $categories;
    }
	
}
