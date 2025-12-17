<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "carts".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $cost
 *
 * @property Orders[] $orders
 * @property Product $product
 * @property User $user
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'cost'], 'required'],
            [['product_id', 'user_id'], 'integer'],
            [['cost'], 'string', 'max' => 100],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Товар',
            'user_id' => 'Пользователь',
            'cost' => 'Цена',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['carts_id' => 'id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Получает название товара.
     * @return string
     */
    public function getProductName()
    {
        return $this->product ? $this->product->name : 'Товар удален';
    }

    /**
     * Получает категорию товара.
     * @return string
     */
    public function getProductCategory()
    {
        return $this->product ? $this->product->kategoty : '-';
    }

    /**
     * Получает имя пользователя.
     * @return string
     */
    public function getUserName()
    {
        return $this->user ? $this->user->fio : 'Гость';
    }

    /**
     * Проверяет, является ли текущий пользователь владельцем корзины.
     * @return bool
     */
    public function isOwner()
    {
        return !Yii::$app->user->isGuest && $this->user_id == Yii::$app->user->identity->id;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && Yii::$app->user->isGuest) {
                $this->addError('user_id', 'Только авторизованные пользователи могут добавлять товары в корзину.');
                return false;
            }
            return true;
        }
        return false;
    }

    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['carts_id' => 'id']);
    }
}