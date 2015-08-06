<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Category;
use common\models\Region;

use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
	
	public $userCategories;
	public $userCategoriesList;
	public $category_id;
	public $check_license;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'status', 'user_status', 'is_active', 'created_at', 'updated_at', 'user_type', 'region_id', 'to_client', 'call_time_from', 'call_time_to', 'black_list', 'license_checked', 'payment_type', 'category_id', 'check_license'], 'integer'],
            [['username', 'email', 'fio', 'phone', 'about', 'education', 'experience', 'price_list', 'avatar', 'price_t', 'specialization', 'license'], 'safe'],
            [['total_rating'], 'number'],
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
            'user_status' => 'Статус',
            'fio' => 'ФИО',
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
        $query = User::find()
			//->joinWith(['userCategories'])
			->joinWith(['userCategoriesArray'])
			->joinWith(['userRegion'])
			->where(['group_id' => 2])
			->andWhere('{{%user}}.id > 0');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
			'{{%user}}.id' => $this->id,
            'group_id' => $this->group_id,
            'status' => $this->status,
            'user_status' => $this->user_status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_type' => $this->user_type,
            'region_id' => $this->regionIds,
            'to_client' => $this->to_client,
            'call_time_from' => $this->call_time_from,
            'call_time_to' => $this->call_time_to,
            'total_rating' => $this->total_rating,
            'black_list' => $this->black_list,
            'license_checked' => $this->license_checked,
            'payment_type' => $this->payment_type,
            'category_id' => $this->categoryIds,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'price_t', $this->price_t])
            ->andFilterWhere(['like', 'specialization', $this->specialization])
            ->andFilterWhere(['like', 'license', $this->license]);
		
		if($this->check_license == 1)	{
			$timestamp = time();
			//echo'<pre>';print_r($timestamp);echo'</pre>';die;

			$date_time_array = getdate($timestamp);
			//echo'<pre>';print_r($date_time_array);echo'</pre>';//die;
			//echo'<pre>';print_r(Yii::$app->formatter->asDate($timestamp, 'php:d-m-yy'));echo'</pre>';//die;


			$hours = $date_time_array['hours'];
			$minutes = $date_time_array['minutes'];
			$seconds = $date_time_array['seconds'];
			$month = $date_time_array['mon'];
			$day = $date_time_array['mday'];
			$year = $date_time_array['year'];

			// используйте mktime для обновления UNIX времени
			/*
			$timestamp = mktime($hours,$minutes,$seconds,$month,($day - 55),$year);
			$date_time_array = getdate($timestamp);
			echo'<pre>';print_r($timestamp);echo'</pre>';//die;

			echo'<pre>';print_r($date_time_array);echo'</pre>';//die;
			echo'<pre>';print_r(Yii::$app->formatter->asDate($timestamp, 'php:d F'));echo'</pre>';//die;
			*/
			$start_day = $day + 6;
			
			$timestamp = mktime(0, 0, 0, $month, $start_day, $year);
			
			//$query->andFilterWhere(['license_checked<=:timestamp', [':timestamp' => $timestamp]]);
			$query->andFilterWhere(['<=', 'license_checked', $timestamp]);
			$timestamp = mktime(0, 0, 0, $month, $day, $year);
			$query->andFilterWhere(['>=', 'license_checked', $timestamp]);
			
		}

        return $dataProvider;
    }
	
    public function getDropdownCatList()
    {
 		$categories = Category::find()
			->where('id <> 1')
			->andWhere('depth < 3')
			->orderBy('lft, rgt')->all();

		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$categories = ArrayHelper::map($categories, 'id', 'name');

		return $categories;

    }
	
	public function getCategoryIds()
	{
		$userSearch = Yii::$app->request->get('UserSearch', []);
		if(isset($userSearch['category_id']) && $userSearch['category_id'] != 0) {
			
			$category = Category::findOne($userSearch['category_id']);
			$children = $category->children()->all();
			
			$res = [$userSearch['category_id'] => $userSearch['category_id']] + ArrayHelper::map($children, 'id', 'id');
		}	else	{
			$res = 	[];
		}
		
		//echo'<pre>';print_r($res);echo'</pre>';die;
		
		return $res;
	}
	
    public function getDropdownRegionsList()
    {
 		$categories = Region::find()
			->where('id <> 1')
			->orderBy('lft, rgt')->all();

		foreach($categories as $c){
			$separator = '';
			for ($x=0; $x++ < $c->depth;) $separator .= '-';
			$c->name = $separator.$c->name;
		}
		
		$categories = ArrayHelper::map($categories, 'id', 'name');

		return $categories;
    }
	
	public function getRegionIds()
	{
		$userSearch = Yii::$app->request->get('UserSearch', []);
		if(isset($userSearch['region_id']) && $userSearch['region_id'] != 0) {
			
			$category = Region::findOne($userSearch['region_id']);
			$children = $category->children()->all();
			
			$res = [$userSearch['region_id'] => $userSearch['region_id']] + ArrayHelper::map($children, 'id', 'id');
		}	else	{
			$res = 	[];
		}
		
		//echo'<pre>';print_r($res);echo'</pre>';die;
		
		return $res;
	}
	
	
}