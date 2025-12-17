<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Carts;

/**
 * CartsSearch represents the model behind the search form of `app\models\Carts`.
 */
class CartsSearch extends Carts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id'], 'integer'],
            [['cost'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Carts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Фильтрация
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'cost', $this->cost]);

        return $dataProvider;
    }

    /**
     * Поиск только для текущего пользователя
     *
     * @param array $params
     * @param int $userId ID пользователя
     * @return ActiveDataProvider
     */
    public function searchForUser($params, $userId)
    {
        $query = Carts::find()
            ->joinWith(['product'])
            ->where(['carts.user_id' => $userId]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Фильтрация
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'cost', $this->cost]);

        return $dataProvider;
    }
}