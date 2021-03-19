<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m210310_111501_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%files}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(),
            'path' => $this->string(),
            'name' => $this->string(),
            'sizex' => $this->integer(),
            'sizey' => $this->integer(),
            'mime' => $this->string(),
            'weight' => $this->integer(),
            'created' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-files-uid',
            'files',
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
        $this->dropTable('{{%files}}');

        $this->dropForeignKey(
            'fk-files-uid',
            'files'
        );
    }

}
