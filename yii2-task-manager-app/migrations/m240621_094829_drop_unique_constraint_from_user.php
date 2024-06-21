<?php

use yii\db\Migration;

/**
 * Class m240621_094829_drop_unique_constraint_from_user
 */
class m240621_094829_drop_unique_constraint_from_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE [user] DROP CONSTRAINT [UQ__user__4EDC6DFC8D7C1B12]');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240621_094829_drop_unique_constraint_from_user cannot be reverted.\n";
        $this->execute('ALTER TABLE [user] ADD CONSTRAINT [UQ__user__4EDC6DFC8D7C1B12] UNIQUE ([username])');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240621_094829_drop_unique_constraint_from_user cannot be reverted.\n";

        return false;
    }
    */
}
