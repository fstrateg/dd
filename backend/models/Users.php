<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $role
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Users extends ActiveRecord
{
    var $npassword;
    var $cpassword;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username','role'],'required']
        ];
    }

    public function attributeLabels()
    {
        return [
                'username'=>'Имя пользователя',
                'npassword'=>'Пароль',
                'cpassword'=>'Повтор пароля',
                'role'=>'Роль'
        ];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}