<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%dishes}}`.
 */
class m210301_043415_add_status_id_column_to_dishes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%dishes}}', 'status_id', $this->integer()->defaultValue(1));
        $this->addForeignKey(
            '{{%fk-dishes-status_id}}',
            '{{%dishes}}',
            'status_id',
            '{{%statuses}}',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-dishes-status_id',
            'dishes'
        );
        $this->dropColumn('{{%dishes}}', 'status_id');
    }
}