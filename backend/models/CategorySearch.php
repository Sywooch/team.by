<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tree', 'lft', 'rgt', 'depth', 'parent_id', 'popular'], 'integer'],
            [['name', 'alias', 'path', 's_descr', 'description', 'meta_title', 'meta_keyword', 'meta_descr'], 'safe'],
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
        $query = Category::find()
			->where(['<>', 'id', 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => ['defaultOrder'=>['lft' => SORT_ASC, 'rgt' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'tree' => $this->tree,
            'lft' => $this->lft,
            'rgt' => $this->rgt,
            'depth' => $this->depth,
            'parent_id' => $this->parent_id,
            'popular' => $this->popular,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 's_descr', $this->s_descr])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title])
            ->andFilterWhere(['like', 'meta_keyword', $this->meta_keyword])
            ->andFilterWhere(['like', 'meta_descr', $this->meta_descr]);

        return $dataProvider;
    }
}
