<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'email',
        'matricule',
        'password',
        'role',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Auto-hash password on insert and update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_DEFAULT
            );
        }
        return $data;
    }

    // ── Finders ──────────────────────────────────────────────────────────────

    public function findByEmail(string $email): array|null
    {
        return $this->where('email', $email)
                    ->where('is_active', 1)
                    ->first();
    }

    public function findByMatricule(string $matricule): array|null
    {
        return $this->where('matricule', $matricule)
                    ->where('role', 'student')
                    ->where('is_active', 1)
                    ->first();
    }

    public function findByEmailAndRole(string $email, string $role): array|null
    {
        return $this->where('email', $email)
                    ->where('role', $role)
                    ->where('is_active', 1)
                    ->first();
    }
}