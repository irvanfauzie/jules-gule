<?php

namespace App\Models;

use CodeIgniter\Model;

class ChunkModel extends Model
{
    protected $table            = 'document_chunks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['document_id', 'chunk_content', 'metadata'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function searchChunks(string $query, int $limit = 5)
    {
        return $this->select('document_chunks.*, documents.title as doc_title')
                    ->join('documents', 'documents.id = document_chunks.document_id')
                    ->where("MATCH(chunk_content) AGAINST('" . $this->db->escapeString($query) . "' IN NATURAL LANGUAGE MODE)")
                    ->limit($limit)
                    ->get()
                    ->getResultArray();
    }
}
