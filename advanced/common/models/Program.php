<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "program".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property string|null $base
 * @property string|null $type
 * @property string|null $financing
 * @property string|null $region
 */
class Program extends \yii\db\ActiveRecord
{
    const _TYPES = [1 => 'очно', 2 => 'очно-заочно'];
    const _FINANCING = [1 => 'договор', 2 => 'бюджет'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name', 'base', 'type', 'financing', 'region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'base' => 'Base',
            'type' => 'Type',
            'financing' => 'Financing',
            'region' => 'Region',
        ];
    }

    /**
     * @param integer $uid user id
     * @return array of id => name
     */
    public static function getAvailable($uid)
    {
        return $arr = [];
    }
}
