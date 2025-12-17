<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $login
 * @property string $password
 * @property string $email
 * @property string $number
 * @property int $user_role
 *
 * @property Orders $orders
 * @property Role $userRole
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
/* Реализуем методы наследуемого интерфейса */
public function getId()
{
return $this->id;
}
public function validateAuthKey($authKey)
{
return false;
}
public function getAuthKey()
{
return null;
}
public static function findIdentity($id)
{
return static::findOne($id);
}
public static function findIdentityByAccessToken($token, $type = null)
{
return null;
}
/* Поиск пользователя по логину и проверка введенного пароля */
public static function findByUsername($login)
{
return User::findOne(['login' => $login]);
}
public function validatePassword($password)
{
return $this->password === $password;
}
/* Проверка на вход администратора */
public function isAdmin(){
return $this->userRole->code === "admin";
}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'login', 'password', 'email', 'number'], 'required'],
            [['user_role'], 'integer'],
            [['fio', 'login', 'password', 'email'], 'string', 'max' => 100],
            [['number'], 'string', 'max' => 15],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['number'], 'unique'],
            [['user_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['user_role' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email',
            'number' => 'Номер телефона',
            'user_role' => 'User Role',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(Role::class, ['id' => 'user_role']);
    }
}
