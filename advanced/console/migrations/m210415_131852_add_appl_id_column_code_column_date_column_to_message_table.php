<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%message}}`.
 */
class m210415_131852_add_appl_id_column_code_column_date_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%message}}', 'appl_id', $this->integer());
        $this->addColumn('{{%message}}', 'date', $this->integer());
        $this->addColumn('{{%message}}', 'code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%message}}', 'appl_id');
        $this->dropColumn('{{%message}}', 'date');
        $this->dropColumn('{{%message}}', 'code');
    }
}
