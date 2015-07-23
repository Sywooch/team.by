<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
	public $clientName;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'category_id', 'user_id', 'created_at', 'updated_at', 'date_control', 'price1', 'price', 'fee', 'status', 'payment_status', 'review_status'], 'integer'],
            [['descr', 'review_text', 'clientName'], 'safe'],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$dataProvider->setSort([
			'attributes' => [
				//'id',
				/* http://nix-tips.ru/yii2-sortirovka-i-filtr-gridview-po-svyazannym-i-vychislyaemym-polyam.html
				'fullName' => [
				'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
				'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
				'label' => 'Full Name',
				'default' => SORT_ASC
				],
				*/
				'clientName' => [
					'asc' => ['{{client}}.fio' => SORT_ASC],
					'desc' => ['{{client}}.fio' => SORT_DESC],
					'label' => 'Country Name'
				]
			]
		]);		

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
			
			
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
            ->andFilterWhere(['like', 'review_text', $this->review_text]);

        return $dataProvider;
    }
}
