<?php

use yii\db\Migration;

class m170925_153721_create_news extends Migration
{
    public function safeUp()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255)->notNull(),
            'description_mini' => $this->text(),
            'description' => $this->text(),
            'image' => $this->string(255),
            'status' => $this->smallInteger(1)->defaultValue(0),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11)
        ]);

        $this->createIndex(
            'index_news_user_id',
            'news',
            'user_id'
        );

        $this->addForeignKey(
            'fk_news_user_id',
            'news',
            'user_id',
            'user',
            'id',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTable('news');
    }
}
