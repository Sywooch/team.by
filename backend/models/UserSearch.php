<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'status', 'user_status', 'is_active', 'created_at', 'updated_at', 'user_type', 'region_id', 'to_client', 'call_time_from', 'call_time_to', 'black_list', 'license_checked', 'payment_type'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'fio', 'phone', 'about', 'education', 'experience', 'price_list', 'avatar', 'price_t', 'specialization', 'license'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

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
            'id' => $this->id,
            'group_id' => $this->group_id,
            'status' => $this->status,
            'user_status' => $this->user_status,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_type' => $this->user_type,
            'region_id' => $this->region_id,
            'to_client' => $this->to_client,
            'call_time_from' => $this->call_time_from,
            'call_time_to' => $this->call_time_to,
            'total_rating' => $this->total_rating,
            'black_list' => $this->black_list,
            'license_checked' => $this->license_checked,
            'payment_type' => $this->payment_type,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'price_list', $this->price_list])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'price_t', $this->price_t])
            ->andFilterWhere(['like', 'specialization', $this->specialization])
            ->andFilterWhere(['like', 'license', $this->license]);

        return $dataProvider;
    }
}