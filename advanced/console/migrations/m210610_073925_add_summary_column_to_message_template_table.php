<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%message_template}}`.
 */
class m210610_073925_add_summary_column_to_message_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%message_template}}', 'summary', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%message_template}}', 'summary');
    }
}
