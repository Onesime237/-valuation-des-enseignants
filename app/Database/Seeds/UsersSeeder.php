<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'name'       => 'Administrateur',
                'email'      => 'admin@school.cm',
                'matricule'  => null,
                'password'   => password_hash('Admin@1234', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Dr Martin',
                'email'      => 'martin@school.cm',
                'matricule'  => null,
                'password'   => password_hash('Teacher@1234', PASSWORD_DEFAULT),
                'role'       => 'teacher',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Étudiant Test',
                'email'      => 'etudiant@school.cm',
                'matricule'  => 'ETU001',
                'password'   => password_hash('Student@1234', PASSWORD_DEFAULT),
                'role'       => 'student',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}