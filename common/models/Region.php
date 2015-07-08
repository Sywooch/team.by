<?php

namespace common\models;


use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $parent_id
 * @property integer $popular
 * @property string $name
 * @property string $s_descr
 * @property string $description
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_descr
 */
class Region extends \yii\db\ActiveRecord
{
	public $parent_id_old = 0;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'lft', 'rgt', 'depth', 'parent_id', 'popular'], 'integer'],
            [['name'], 'required'],
            [['description', 'meta_descr'], 'string'],
            [['name', 'meta_title', 'meta_keyword'], 'string', 'max' => 255]
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
            'name' => 'Название региона',
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
        return new RegionQuery(get_called_class());
    }
	
	public function getRegionsList($region_id = 2)
	{
		$regions = Region::find()->where('id <> 1')->orderBy('lft, rgt')->all();
		
		$regions_l1 = [];
		
		$region_str = 'Вся Беларусь';
		
		$region_active = false;

		foreach($regions as $row){
			$region_active = false;
			
			if($row->parent_id == 1) {
				
				if($row->id == $region_id) {
					$region_str = $row->name;
					$region_active = true;
				}
			
				$regions_l1[] = [
					'id'=>$row->id,
					'name'=>$row->name,
					'active'=>$region_active,
					'children'=>[],
				];
			}
		}		
		
		foreach($regions_l1 as &$row_l1){
			foreach($regions as $row){
				$region_active = false;
				
				if($row->parent_id == $row_l1['id']) {
					
					if($row->id == $region_id) {
						$region_str = $row->name;
						$region_active = true;
					}
					
					$row_l1['children'][] = [
						'id'=>$row->id,
						'name'=>$row->name,
						'active'=>$region_active,
					];
				}
			}
		}
		
		if($region_id == 1)	$region_active = true;
			else $region_active = false;
		
		$all_regions[] = [
			'id'=>1,
			'name'=>'Вся Беларусь',
			'active'=>$region_active,
			'children'=>[],
		];
			
		$regions_l1 = array_merge($all_regions, $regions_l1);
		
		return ['list' => $regions_l1, 'active' => $region_str];
		
	}
}
