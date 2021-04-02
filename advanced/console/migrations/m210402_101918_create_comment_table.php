<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m210402_101918_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'appl_id' => $this->integer(),
            'body' => $this->text(),
            'created' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-comment-appl',
            'comment',
            'appl_id',
            'application',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');

        $this->dropForeignKey(
            'fk-comment-uid',
            'comment'
        );
    }
}
