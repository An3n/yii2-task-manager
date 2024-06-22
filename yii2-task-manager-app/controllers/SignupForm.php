<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;


/**
 * SignupForm é o modelo por trás do formulário de registo.
 */
class SignupForm extends Model
{
    public $username; // Armazena o nome de utilizador inserido
    public $password; // Armazena a pass inserida


    /**
     * Define as regras de validação para o formulário de registo.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'], // Nome de utilizador e pass são obrigatórios
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'], // O nome de utilizador deve ser único
        ];
    }

    /**
     * Faz o registo do utilizador utilizando o nome de utilizador e pass fornecidos.
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
