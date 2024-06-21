<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240620_185431_create_user_table extends Migration
{
     /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'access_token' => $this->string(32)->unique(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->execute('
            CREATE TRIGGER trg_user_updated_at
            ON [user]
            AFTER UPDATE
            AS
            BEGIN
                SET NOCOUNT ON;
                UPDATE [user] SET updated_at = CURRENT_TIMESTAMP WHERE id IN (SELECT id FROM inserted);
            END
        ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TRIGGER IF EXISTS trg_user_updated_at');
        $this->dropTable('{{%user}}');
    }
}