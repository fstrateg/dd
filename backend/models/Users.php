<?php
namespace backend\models;

use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Users extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            [
                'username'=>'Пользователь',
                'password'=>'Пароль'
            ]
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}