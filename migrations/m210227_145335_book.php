<?php

use yii\db\Migration;

/**
 * Class m210227_145335_books
 */
class m210227_145335_book extends Migration
{
    const TABLE_NAME = 'book';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'desc' => $this->string(255)->notNull(),
            'writer_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_writer', self::TABLE_NAME, 'writer_id', 'writer', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
