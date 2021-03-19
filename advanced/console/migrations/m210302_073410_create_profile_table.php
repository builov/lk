<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m210302_073410_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'uid' => $this->primaryKey(),
            'lastname' => $this->string(),
            'firstname' => $this->string(),
            'patronim' => $this->string(),
            'birthdate' => $this->date(),
            'snils' => $this->string(),
            'gender' => $this->integer(),

            'education_level' => $this->integer(),
            'institution' => $this->string(),
            'graduate_year' => $this->integer(),

            'passport_series' => $this->string(),
            'passport_number' => $this->integer(),
            'passport_issued' => $this->text(),
            'passport_code' => $this->string(),
            'passport_date' => $this->date(),

            'region' => $this->integer(),
            'address_passport' => $this->text(),
            'address_current' => $this->text(),
            'zip' => $this->integer(),
            'phone' => $this->string(),
//            'email' => $this->string(),
            'agree' => $this->integer(),

            'created' => $this->integer(),
            'updated' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profile}}');
    }
}
