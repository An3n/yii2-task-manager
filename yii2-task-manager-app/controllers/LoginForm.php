<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * LoginForm é o modelo por trás do formulário de login.
 */
class LoginForm extends Model
{
    public $username; // Armazena o nome de utilizador inserido
    public $password; // Armazena a pass inserida
    public $rememberMe = true; // Armazena o valor de rememberMe

    private $_user = false; // Armazena a instância de utilizador

    public function rules()
    {
        return [
            [['username', 'password'], 'required'], // Nome de utilizador e pass são obrigatórios
            ['rememberMe', 'boolean'], // rememberMe deve ser um valor booleano
            ['password', 'validatePassword'], // a pass é validada pelo validatePassword()
        ];
    }

    /**
     * Valida a pass.
     * Este método serve como validador inline para a pass.
     *
     * @param string $attribute o atributo atualmente sendo validado
     * @param array $params os pares de nome-valor adicionais dados na regra
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Encontra o utilizador pelo nome de utilizador.
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Faz o login do utilizador usando o nome de utilizador e pass fornecidos.
     *
     * @return bool se o utilizador fez login com sucesso
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
}
