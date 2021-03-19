<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m210310_111541_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(),
	        'program_id' => $this->integer(),
            'status' => $this->integer(),
            'created' => $this->integer(),
            'updated' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-application-uid',
            'application',
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
        $this->dropTable('{{%application}}');

        $this->dropForeignKey(
            'fk-application-uid',
            'application'
        );
    }
}
