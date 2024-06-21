<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m240620_184714_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Creating the 'task' table with necessary columns
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(), // Primary key column
            'title' => $this->string()->notNull(), // Title column
            'description' => $this->text(), // Description column
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'), // Created at timestamp
            'completed_at' => $this->dateTime(), // Completed at timestamp
            'status' => $this->string()->notNull()->defaultValue('pending'), // Status column with default value
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Dropping the 'task' table
        $this->dropTable('{{%task}}');
    }
}
