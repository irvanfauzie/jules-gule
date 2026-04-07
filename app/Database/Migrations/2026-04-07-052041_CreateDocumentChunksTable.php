<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentChunksTable extends Migration
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
            'document_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'chunk_content' => [
                'type' => 'TEXT',
            ],
            'metadata' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('document_id', 'documents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('document_chunks');

        // Add Full-Text Index
        $this->db->query("ALTER TABLE document_chunks ADD FULLTEXT(chunk_content)");
    }

    public function down()
    {
        $this->forge->dropTable('document_chunks');
    }
}
