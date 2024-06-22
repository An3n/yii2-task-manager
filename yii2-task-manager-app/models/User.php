<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Este é o modelo de classe para a tabela "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string|null $access_token
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    // Define o nome da tabela associada a este modelo.
    public static function tableName()
    {
        return 'user';
    }

    // Define as regras de validação para os atributos do modelo.
    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_key'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['access_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

   // Define os nomes dos atributos para os campos do formulário.
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // Implementações de métodos da interface IdentityInterface
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    // Define a pass do utilizador, gerando um hash da pass fornecida.
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    // Gera uma chave de autenticação para o utilizador.
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
    }
}
