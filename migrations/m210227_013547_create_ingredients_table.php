<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ingredients}}`.
 */
class m210227_013547_create_ingredients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'status_id' => $this->integer()->defaultValue(1),
        ], $tableOptions);

        $this->addForeignKey(
            '{{%fk-ingredients-status_id}}',
            '{{%ingredients}}',
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
            'fk-ingredients-status_id',
            'ingredients'
        );

        $this->dropTable('{{%ingredients}}');
    }
}
