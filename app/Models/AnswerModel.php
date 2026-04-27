<?php

namespace App\Models;

use CodeIgniter\Model;

class AnswerModel extends Model
{
    protected $table            = 'answers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'evaluation_id',
        'question_id',
        'score',
        'text_answer',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Save all answers for an evaluation (batch insert)
    public function saveAnswers(int $evaluationId, array $answers): void
    {
        foreach ($answers as $answer) {
            $this->insert([
                'evaluation_id' => $evaluationId,
                'question_id'   => $answer['question_id'],
                'score'         => $answer['score'] ?? null,
                'text_answer'   => $answer['text_answer'] ?? null,
            ]);
        }
    }

    // Get all answers for an evaluation with question details
    public function getAnswersByEvaluation(int $evaluationId): array
    {
        return $this->db->table('answers a')
                        ->select('a.score, a.text_answer, q.text as question_text, q.type as question_type')
                        ->join('questions q', 'q.id = a.question_id')
                        ->where('a.evaluation_id', $evaluationId)
                        ->get()
                        ->getResultArray();
    }
}
