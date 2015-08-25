<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Review;

/**
 * ReviewSearch represents the model behind the search form about `common\models\Review`.
 */
class ReviewSearch extends Review
{
	
	public $client;
	public $user;
	public $order;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'client_id', 'user_id', 'review_rating', 'created_at', 'updated_at', 'status', 'answer_status'], 'integer'],
            [['review_text', 'youtube', 'answer_text', 'client', 'user', 'order'], 'safe'],
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
        $query = Review::find()
			->joinWith(['client'])
			->joinWith(['user'])
			->joinWith(['order']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['defaultOrder'=>['id' => SORT_DESC]]
        ]);
		
		$dataProvider->sort->attributes['order'] = [
			'asc' => ['{{%order}}.id' => SORT_ASC],
			'desc' => ['{{%order}}.id' => SORT_DESC],
		];		
		
		$dataProvider->sort->attributes['client'] = [
			'asc' => ['{{%client}}.fio' => SORT_ASC],
			'desc' => ['{{%client}}.fio' => SORT_DESC],
		];		
		
		$dataProvider->sort->attributes['user'] = [
			'asc' => ['{{%user}}.fio' => SORT_ASC],
			'desc' => ['{{%user}}.fio' => SORT_DESC],
		];		

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'order_id' => $this->order_id,
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'review_rating' => $this->review_rating,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'answer_status' => $this->answer_status,
        ]);

        $query->andFilterWhere(['like', 'review_text', $this->review_text])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'answer_text', $this->answer_text])
			->andFilterWhere(['like', '{{%client}}.fio', $this->client])
			->andFilterWhere(['like', '{{%user}}.fio', $this->user]);


        return $dataProvider;
    }
}
