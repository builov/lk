<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%application}}`.
 */
class m210402_104316_add_show_message_column_to_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%application}}', 'show_message', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%application}}', 'show_message');
    }
}
