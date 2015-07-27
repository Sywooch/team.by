<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserToAdministration;

class UserToAdministrationSearch extends UserToAdministration
{
	public $spec;
	public $statusName;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['spec'], 'safe'],
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
        $query = UserToAdministration::find();
		$query->joinWith(['user']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$dataProvider->sort->attributes['spec'] = [
			'asc' => ['{{%user}}.fio' => SORT_ASC],
			'desc' => ['{{%user}}.fio' => SORT_DESC],
		];		
		
		$dataProvider->sort->attributes['statusName'] = [
			'asc' => ['{{%user_to_administration}}.status' => SORT_ASC],
			'desc' => ['{{%user_to_administration}}.status' => SORT_DESC],
		];		
		
		if (!($this->load($params) && $this->validate())) {			
			return $dataProvider;
		}
		
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->client_id,
        ]);

        $query->andFilterWhere(['like', '{{%user}}.fio', $this->spec]);

        return $dataProvider;
    }
}
