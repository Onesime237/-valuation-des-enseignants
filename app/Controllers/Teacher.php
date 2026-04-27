<?php

namespace App\Controllers;

use App\Models\EvaluationModel;
use App\Models\AnswerModel;
use App\Models\EvaluationPdfModel;
use App\Models\CourseModel;
use App\Models\TeacherCourseModel;

class Teacher extends BaseController
{
    public function dashboard(): string
    {
        $userId = session()->get('user_id');
        
        $evaluationModel = new EvaluationModel();
        $pdfModel = new EvaluationPdfModel();
        $courseModel = new CourseModel();
        $teacherCourseModel = new TeacherCourseModel();

        // Get all evaluations for this teacher
        $evaluations = $evaluationModel->getEvaluationsByTeacher($userId);
        
        // Get all PDFs for this teacher
        $pdfs = $pdfModel->getPdfsByTeacher($userId);
        
        // Get courses assigned to this teacher (using model's db connection)
        $teacherCourses = $teacherCourseModel->db->table('teacher_courses tc')
                                    ->select('c.id, c.name as course_name')
                                    ->join('courses c', 'c.id = tc.course_id')
                                    ->where('tc.teacher_id', $userId)
                                    ->get()
                                    ->getResultArray();

        // Calculate average scores
        $averageScores = $this->calculateAverageScores($userId);

        $data = [
            'user_name'      => session()->get('user_name'),
            'user_email'     => session()->get('user_email'),
            'evaluations'    => $evaluations,
            'pdfs'           => $pdfs,
            'courses'        => $teacherCourses,
            'averageScores'  => $averageScores,
            'total_evaluations' => count($evaluations),
            'total_pdfs'     => count($pdfs),
        ];

        return view('teacher/dashboard', $data);
    }

    // Calculate average scores for each course
    private function calculateAverageScores(int $teacherId): array
    {
        $answerModel = new AnswerModel();
        
        $answers = $answerModel->db->table('answers a')
                            ->select('q.id as question_id, q.text as question_text, a.score, e.course_id, c.name as course_name')
                            ->join('questions q', 'q.id = a.question_id')
                            ->join('evaluations e', 'e.id = a.evaluation_id')
                            ->join('courses c', 'c.id = e.course_id')
                            ->where('e.teacher_id', $teacherId)
                            ->where('a.score IS NOT NULL')
                            ->get()
                            ->getResultArray();

        $courseScores = [];
        foreach ($answers as $answer) {
            $courseName = $answer['course_name'];
            if (!isset($courseScores[$courseName])) {
                $courseScores[$courseName] = ['total' => 0, 'count' => 0];
            }
            $courseScores[$courseName]['total'] += (int)$answer['score'];
            $courseScores[$courseName]['count']++;
        }

        $averages = [];
        foreach ($courseScores as $course => $data) {
            $averages[$course] = $data['count'] > 0 
                ? round($data['total'] / $data['count'], 2) 
                : 0;
        }

        return $averages;
    }

    // Download PDF (same as admin)
    public function downloadPdf(int $id)
    {
        $pdfModel = new EvaluationPdfModel();
        $pdf = $pdfModel->find($id);

        if (!$pdf) {
            return redirect()->to('/teacher/dashboard')
                             ->with('error', 'PDF not found.');
        }

        $filePath = WRITEPATH . 'pdfs/' . $pdf['file_path'];

        if (!file_exists($filePath)) {
            return redirect()->to('/teacher/dashboard')
                             ->with('error', 'PDF file not found on server.');
        }

        return $this->response->download($filePath, null);
    }
}
