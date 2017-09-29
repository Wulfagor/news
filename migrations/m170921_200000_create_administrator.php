<?php

use yii\db\Migration;
use dektrium\user\helpers\Password;

class m170921_200000_create_administrator extends Migration
{
    public function safeUp()
    {
        $this->insert('user', [
            'id' => 1,
            'username' => 'administrator',
            'email' => 'administrator@szprogr.ru',
            'password_hash' => Password::hash('administrator'),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'confirmed_at' => time(),
            'unconfirmed_email' => NULL,
            'blocked_at' => NULL,
            'registration_ip' => '127.0.0.1',
            'created_at' => time(),
            'updated_at' => time(),
            'flags' => 0,
            'last_login_at' => NULL
        ]);

        $this->insert('auth_assignment', [
            'item_name' => 'Admin',
            'user_id' => 1,
            'created_at' => time()
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', [
            'id' => 1
        ]);

        $this->delete('auth_assignment', [
            'user_id' => 1
        ]);
    }
}
