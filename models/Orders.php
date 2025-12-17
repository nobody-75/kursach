<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $carts_id
 * @property string $payment
 * @property string $status
 * @property string $date
 *
 * @property Carts $cart
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['carts_id'], 'required'],
            [['carts_id'], 'integer'],
            [['payment', 'status'], 'string'],
            [['date'], 'safe'],
            [['carts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carts::class, 'targetAttribute' => ['carts_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'carts_id' => 'ID корзины',
            'payment' => 'Способ оплаты',
            'status' => 'Статус',
            'date' => 'Дата заказа',
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Carts::class, ['id' => 'carts_id']);
    }
}