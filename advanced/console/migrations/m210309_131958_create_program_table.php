<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%program}}`.
 */
class m210309_131958_create_program_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%program}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'status' => $this->integer()->defaultValue(1),
            'base' => $this->string(),
            'type' => $this->string(),
            'financing' => $this->string(),
            'region' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%program}}');
    }
}
