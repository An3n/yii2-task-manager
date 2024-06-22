<?php

use yii\db\Migration;

/**
 * Class m240622_155126_add_user_id_to_task
 */
class m240622_155126_add_user_id_to_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%task}}', 'user_id', $this->integer()->notNull());

        // Cria um índice para a coluna `user_id`
        $this->createIndex(
            'idx-task-user_id',
            '{{%task}}',
            'user_id'
        );

        // Adiciona chave estrangeira para a tabela `user`
        $this->addForeignKey(
            'fk-task-user_id',
            '{{%task}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove chave estrangeira e índice
        $this->dropForeignKey(
            'fk-task-user_id',
            '{{%task}}'
        );

        $this->dropIndex(
            'idx-task-user_id',
            '{{%task}}'
        );

        $this->dropColumn('{{%task}}', 'user_id');
    }
}
