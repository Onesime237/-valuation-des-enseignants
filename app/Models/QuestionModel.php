<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table            = 'questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'text',
        'type',
        'category_id',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get all active questions, with their category name joined
    public function getActiveWithCategory(): array
    {
        return $this->db->table('questions q')
                        ->select('q.id, q.text, q.type, q.is_active, c.name as category_name')
                        ->join('categories c', 'c.id = q.category_id', 'left')
                        ->where('q.is_active', 1)
                        ->orderBy('c.name', 'ASC')
                        ->orderBy('q.id', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    // Get all questions (active + inactive) with category name — for admin list
    public function getAllWithCategory(): array
    {
        return $this->db->table('questions q')
                        ->select('q.id, q.text, q.type, q.is_active, c.name as category_name')
                        ->join('categories c', 'c.id = q.category_id', 'left')
                        ->orderBy('q.id', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    // Get active questions filtered by category
    public function getByCategory(int $categoryId): array
    {
        return $this->where('category_id', $categoryId)
                    ->where('is_active', 1)
                    ->findAll();
    }
}