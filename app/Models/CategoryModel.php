<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'description',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get all categories as a simple id => name array (useful for dropdowns)
    public function getDropdown(): array
    {
        $rows = $this->findAll();
        $dropdown = [];
        foreach ($rows as $row) {
            $dropdown[$row['id']] = $row['name'];
        }
        return $dropdown;
    }
}