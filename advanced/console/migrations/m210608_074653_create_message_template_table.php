<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message_template}}`.
 */
class m210608_074653_create_message_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message_template}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'body' => $this->text(),
            'template' => $this->text(),
        ]);

        $this->createIndex(
            'idx-message_template-code',
            'message_template',
            'code'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-message_template-code',
            'message_template'
        );

        $this->dropTable('{{%message_template}}');
    }
}
