<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * SignupForm é o modelo por trás do formulário de inscrição.
 */
class SignupForm extends Model
{
    public $username; // Armazena o nome de utilizador inserido
    public $password; // Armazena a pass inserida

    // Define as regras de validação para o formulário de signup.
    public function rules()
    {
        return [
            [['username', 'password'], 'required'], // Nome de utilizador e senha são obrigatórios
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'], // O nome de utilizador deve ser único
        ];
    }

    /**
     * Faz o registo do utilizador usando o nome de utilizador e a pass fornecidos.
     *
     * @return User|null o modelo guardado ou null se guardar falhar
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            return $user->save() ? $user : null;
        }
        return null;
    }
}
