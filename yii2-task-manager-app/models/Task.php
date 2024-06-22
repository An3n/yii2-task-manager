<?php

namespace app\models;

use Yii;

/**
 * Este é o modelo de classe para a tabela "task".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string|null $created_at
 * @property string|null $completed_at
 * @property int $user_id
 */


class Task extends \yii\db\ActiveRecord
{
    // Define o nome da tabela associada a este modelo.
    public static function tableName()
    {
        return 'task';
    }

     // Define as regras de validação para os atributos do modelo.
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['created_at', 'completed_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    // Define os nomes dos atributos para os campos do formulário.
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Executa ações antes de guardar o modelo.
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->status === 'completed' && empty($this->completed_at)) {
                $this->completed_at = date('Y-m-d H:i:s');
            } elseif ($this->status !== 'completed') {
                $this->completed_at = null; // Limpa completed_at se o status não for completed
            }
            return true;
        }
        return false;
    }

    /**
     * Define a relação entre Task e User.
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
