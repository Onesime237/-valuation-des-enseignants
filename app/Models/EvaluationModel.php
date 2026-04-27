<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationModel extends Model
{
    protected $table            = 'evaluations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'teacher_id',
        'course_id',
        'status',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get all evaluations for a specific student
    public function getEvaluationsByStudent(int $studentId): array
    {
        return $this->db->table('evaluations e')
                        ->select('e.id, e.status, e.created_at, u.name as teacher_name, c.name as course_name')
                        ->join('users u', 'u.id = e.teacher_id')
                        ->join('courses c', 'c.id = e.course_id')
                        ->where('e.student_id', $studentId)
                        ->orderBy('e.created_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    // Get all evaluations for a specific teacher
    public function getEvaluationsByTeacher(int $teacherId): array
    {
        return $this->db->table('evaluations e')
                        ->select('e.id, e.status, e.created_at, u.name as student_name, c.name as course_name')
                        ->join('users u', 'u.id = e.student_id')
                        ->join('courses c', 'c.id = e.course_id')
                        ->where('e.teacher_id', $teacherId)
                        ->orderBy('e.created_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    // Check if student already evaluated this teacher for this course
    public function alreadyEvaluated(int $studentId, int $teacherId, int $courseId): bool
    {
        return $this->where('student_id', $studentId)
                    ->where('teacher_id', $teacherId)
                    ->where('course_id', $courseId)
                    ->countAllResults() > 0;
    }
}
