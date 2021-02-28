<?php

use yii\db\Migration;

/**
 * Class m210227_145255_writers
 */
class m210227_145255_writer extends Migration
{
    const TABLE_NAME = 'writer';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'user_id' => $this->integer()->notNull()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_user', self::TABLE_NAME, 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
