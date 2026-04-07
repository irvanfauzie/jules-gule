<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'session_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'sender' => [
                'type'       => 'ENUM',
                'constraint' => ['user', 'bot'],
                'default'    => 'user',
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'references' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chat_history');
    }

    public function down()
    {
        $this->forge->dropTable('chat_history');
    }
}
