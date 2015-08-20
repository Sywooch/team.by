<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Category;
use common\models\User;
use common\models\UserCategories;
use common\models\UserSpecials;
use common\models\Region;

use yii\helpers\ArrayHelper;


/**
 * UserSearch represents the model behind the search form about `common\models\Order`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
    public function attributeLabels()
    {
        return [
        ];
    }
	

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /*
		$query = Order::find();
		$query->joinWith(['client']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$dataProvider->sort->attributes['client'] = [
			'asc' => ['{{%client}}.fio' => SORT_ASC],
			'desc' => ['{{%client}}.fio' => SORT_DESC],
		];		
		
		if (!($this->load($params) && $this->validate())) {			
			return $dataProvider;
		}
		
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'date_control' => $this->date_control,
            'price1' => $this->price1,
            'price' => $this->price,
            'fee' => $this->fee,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'review_status' => $this->review_status,
        ]);

        $query->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'review_text', $this->review_text])
			->andFilterWhere(['like', '{{%client}}.fio', $this->client]);

        return $dataProvider;
		*/
    }
	
	
    public function searchUsers($search = ' ', $region_id = 1)
    {
		$region_ids = [];

		if($region_id != 1) {
			$region = Region::findOne($region_id);
			$region_children = $region->children()->all();
			$region_ids = [$region_id => $region_id] + ArrayHelper::map($region_children, 'id', 'id');
		}

		//ищем по ФИО и специализации
		$query = User::find()
			->select(['{{%user}}.id'])
			->asArray()
			->where(['like', 'fio', $search])			
			->orWhere(['like', 'specialization', $search])
			->andWhere(['<>', 'black_list', 1])
			->andWhere(['=', 'is_active', 1])
			->andWhere(['user_status'=>[2,10]]);


		if(count($region_ids)) {
			$query->joinWith(['userRegionsList'])
				->andWhere(['region_id' => $region_ids]);
		}
			
		
		$search1 = $query->column();
		/*
		//ищем по категориям
		$categories = Category::find()
			->select(['id'])
			->asArray()
			->where(['like', 'name', $search])
			->column();

		$UserCategories = UserCategories::find()
			->select(['user_id'])
			->asArray()
			->where(['category_id' => $categories])
			->column();

		$query = User::find()
			->asArray()
			->where(['id' => $UserCategories]);

		if(count($region_ids))
			$query->andWhere(['region_id' => $region_ids]);

		$search2 = $query->column();

		//ищем по услугам используем опять массив категорий
		// так как услуги это тоже категории только 3-го уровня
		$UserSpecials = UserSpecials::find()
			->select(['user_id'])
			->asArray()
			->where(['category_id' => $categories])
			->column();

		$query = User::find()
			->select(['id'])
			->asArray()
			->where(['id' => $UserSpecials]);

		if(count($region_ids))
			$query->andWhere(['region_id' => $region_ids]);

		$search3 = $query->column();
		*/


		//echo'<pre>';print_r($search1);echo'</pre>';//die;
		//echo'<pre>';print_r($search2);echo'</pre>';//die;
		//echo'<pre>';print_r($search3);echo'</pre>';//die;
		
		//return array_merge($search1, $search2, $search3);
		return $search1;

	}
	
}
