<?php

use yii\db\Migration;

class m240507_145927_add_books_and_authors_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'isbn' => $this->string()->null()->defaultValue(null),
            'description' => $this->text()->null()->defaultValue(null),
            'imageUrl' => $this->string(512)->null()->defaultValue(null),
            'year' => $this->smallInteger()->null()->defaultValue(null),
            'amount' => $this->integer()->defaultValue(0)
        ]);        
        
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'middlename' => $this->string(),
        ]);        
        
        $this->createTable('{{%books_authors}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'FOREIGN KEY ([[book_id]]) REFERENCES `books` ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY ([[author_id]]) REFERENCES `authors` ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);

        $this->createIndex('idx-book-id', '{{%books_authors}}', 'book_id');
        $this->createIndex('idx-author-id', '{{%books_authors}}', 'author_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_authors}}');
        $this->dropTable('{{%authors}}');
        $this->dropTable('{{%books}}');

        return false;
    }
}
