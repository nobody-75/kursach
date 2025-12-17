<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $kategoty
 * @property string $description
 * @property string $cost
 * @property resource $photo
 *
 * @property Orders $orders
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'cost', 'photo'], 'required'],
            [['kategoty', 'photo'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['description', 'cost'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'kategoty' => 'Kategoty',
            'description' => 'Description',
            'cost' => 'Cost',
            'photo' => 'Photo',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['product_id' => 'id']);
    }


public function getPhotoUrl()
{
    if ($this->photo) {
        try {
            if (is_resource($this->photo)) {
                $content = stream_get_contents($this->photo);
            } else {
                $content = $this->photo;
            }
            
            if ($content) {
                $base64 = base64_encode($content);
                return 'data:image/jpeg;base64,' . $base64;
            }
        } catch (\Exception $e) {
            // Логирование ошибки
        }
    }
    return 'https://via.placeholder.com/300x200/6c757d/ffffff?text=No+Image';
}
}
