<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $user_id; // Добавляем для фильтрации по пользователю
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'carts_id', 'user_id'], 'integer'],
            [['payment', 'status', 'date'], 'safe'],
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
        $query = Orders::find()
            ->joinWith(['cart']); // Связь с корзиной

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['date' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'orders.id' => $this->id,
            'carts_id' => $this->carts_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'payment', $this->payment])
            ->andFilterWhere(['like', 'status', $this->status]);
            
        // Фильтр по пользователю (через связь с корзиной)
        if ($this->user_id !== null && $this->user_id !== '') {
            $query->andWhere(['carts.user_id' => $this->user_id]);
        }

        return $dataProvider;
    }
}