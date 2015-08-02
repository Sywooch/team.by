<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Order;

use frontend\helpers\DDateHelper;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
	public $client;
	public $user;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'category_id', 'user_id', 'created_at', 'updated_at', 'date_control', 'price1', 'price', 'fee', 'status', 'payment_status', 'review_status'], 'integer'],
            [['client', 'user'], 'safe'],
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
            'client' => 'Клиент',
            'user' => 'Исполнитель',
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
        $query = Order::find();
		$query->joinWith(['client']);
		$query->joinWith(['user']);
		
		if(isset($params['date'])) {
			$date = DDateHelper::DateToUnix($params['date'], 2);
			$query->andWhere(['date_control'=>$date]);
		}
		
		//echo'<pre>';print_r($params);echo'</pre>';//die;
		//echo'<pre>';print_r($date);echo'</pre>';die;
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$dataProvider->sort->attributes['client'] = [
			'asc' => ['{{%client}}.fio' => SORT_ASC],
			'desc' => ['{{%client}}.fio' => SORT_DESC],
		];		
		
		$dataProvider->sort->attributes['user'] = [
			'asc' => ['{{%user}}.fio' => SORT_ASC],
			'desc' => ['{{%user}}.fio' => SORT_DESC],
		];		
		
		if (!($this->load($params) && $this->validate())) {			
			return $dataProvider;
		}
		
        $query->andFilterWhere([
            '{{%order}}.id' => $this->id,
            'client_id' => $this->client_id,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'date_control' => $this->date_control,
            'price1' => $this->price1,
            'price' => $this->price,
            'fee' => $this->fee,
            '{{%order}}.status' => $this->status,
            'payment_status' => $this->payment_status,
            'review_status' => $this->review_status,
        ]);

        $query->andFilterWhere(['like', 'descr', $this->descr])
            ->andFilterWhere(['like', 'review_text', $this->review_text])
			->andFilterWhere(['like', '{{%client}}.fio', $this->client])
			->andFilterWhere(['like', '{{%user}}.fio', $this->user]);

        return $dataProvider;
    }
}
