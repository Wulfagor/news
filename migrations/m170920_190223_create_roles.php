<?php

use yii\db\Migration;

class m170920_190223_create_roles extends Migration
{
    public function safeUp()
    {
        $this->insert('auth_item', [
            'name' => 'Admin',
            'type' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('auth_item', [
            'name' => 'ContentManager',
            'type' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('auth_item', [
            'name' => 'User',
            'type' => 1,
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    public function safeDown()
    {
        $this->delete('auth_item', [
            'in', 'name', [
                'Admin',
                'ContentManager',
                'User'
            ]
        ]);
    }
}
