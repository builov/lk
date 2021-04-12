<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m210412_065636_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(),
            'type' => $this->integer(),
            'body' => $this->text(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-message-uid',
            'message',
            'uid',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');

        $this->dropForeignKey(
            'fk-message-uid',
            'message'
        );
    }
}
