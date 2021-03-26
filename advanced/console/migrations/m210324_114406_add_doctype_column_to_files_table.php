<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%files}}`.
 */
class m210324_114406_add_doctype_column_to_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%files}}', 'doctype', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%files}}', 'doctype');
    }
}
