<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluationPdfModel extends Model
{
    protected $table            = 'evaluation_pdfs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'evaluation_id',
        'file_path',
        'generated_at',
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get PDF by evaluation ID
    public function getPdfByEvaluation(int $evaluationId): ?array
    {
        return $this->where('evaluation_id', $evaluationId)->first();
    }

    // Get all PDFs with evaluation details (for Admin)
    public function getAllWithDetails(): array
    {
        return $this->db->table('evaluation_pdfs p')
                        ->select('p.id, p.file_path, p.generated_at, e.id as evaluation_id, e.status, 
                                  s.name as student_name, t.name as teacher_name, c.name as course_name')
                        ->join('evaluations e', 'e.id = p.evaluation_id')
                        ->join('users s', 's.id = e.student_id')
                        ->join('users t', 't.id = e.teacher_id')
                        ->join('courses c', 'c.id = e.course_id')
                        ->orderBy('p.generated_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }

    // Get PDFs for a specific teacher (for Teacher Dashboard)
    public function getPdfsByTeacher(int $teacherId): array
    {
        return $this->db->table('evaluation_pdfs p')
                        ->select('p.id, p.file_path, p.generated_at, e.id as evaluation_id, e.status, 
                                  s.name as student_name, c.name as course_name')
                        ->join('evaluations e', 'e.id = p.evaluation_id')
                        ->join('users s', 's.id = e.student_id')
                        ->join('courses c', 'c.id = e.course_id')
                        ->where('e.teacher_id', $teacherId)
                        ->orderBy('p.generated_at', 'DESC')
                        ->get()
                        ->getResultArray();
    }
}
