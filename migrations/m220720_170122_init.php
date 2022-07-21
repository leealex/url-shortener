<?php

use yii\db\Migration;

/**
 * Class m220720_170122_init
 */
class m220720_170122_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';

        $this->createTable('{{%url}}', [
            'id' => $this->primaryKey()->unsigned(),
            'token' => $this->string(5),
            'original' => $this->string(2000),
            'created_at' => $this->integer()->notNull()
        ], $options);

        $this->createTable('{{%visit}}', [
            'id' => $this->primaryKey(),
            'url_id' => $this->integer()->unsigned(),
            'created_at' => $this->integer()->notNull()
        ], $options);

        $this->createIndex('token', '{{%url}}', 'token', true);

        $this->addForeignKey('url_visit', '{{%visit}}', 'url_id',
            '{{%url}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('url_visit', '{{%visit}}');

        $this->dropTable('{{%url}}');
        $this->dropTable('{{%visit}}');
    }
}
