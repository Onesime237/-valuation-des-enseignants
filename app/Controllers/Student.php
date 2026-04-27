<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\TeacherCourseModel;
use App\Models\QuestionModel;
use App\Models\EvaluationModel;
use App\Models\AnswerModel;
use App\Models\UserModel;
use App\Models\EvaluationPdfModel;

class Student extends BaseController
{
    public function dashboard(): string
    {
        $userId = session()->get('user_id');
        
        $evaluationModel = new EvaluationModel();
        $evaluations = $evaluationModel->getEvaluationsByStudent($userId);

        $data = [
            'user_name'   => session()->get('user_name'),
            'user_email'  => session()->get('user_email'),
            'evaluations' => $evaluations,
        ];

        return view('student/dashboard', $data);
    }

    // List teachers & courses available for evaluation
    public function evaluate(): string
    {
        $userId = session()->get('user_id');
        
        $teacherCourseModel = new TeacherCourseModel();
        $evaluationModel = new EvaluationModel();

        // Get all teacher-course combinations (using model's db connection)
        $teacherCourses = $teacherCourseModel->db->table('teacher_courses tc')
                                    ->select('tc.id as tc_id, u.id as teacher_id, u.name as teacher_name, c.id as course_id, c.name as course_name')
                                    ->join('users u', 'u.id = tc.teacher_id')
                                    ->join('courses c', 'c.id = tc.course_id')
                                    ->where('u.is_active', 1)
                                    ->where('c.is_active', 1)
                                    ->get()
                                    ->getResultArray();

        // Mark which ones the student has already evaluated
        foreach ($teacherCourses as &$tc) {
            $tc['already_evaluated'] = $evaluationModel->alreadyEvaluated($userId, $tc['teacher_id'], $tc['course_id']);
        }

        $data = [
            'teacherCourses' => $teacherCourses,
        ];

        return view('student/evaluate', $data);
    }

    // Show evaluation form for a specific teacher-course
    public function evaluateForm(int $teacherId, int $courseId): string
    {
        $userId = session()->get('user_id');
        
        $evaluationModel = new EvaluationModel();
        $questionModel = new QuestionModel();
        $userModel = new UserModel();
        $courseModel = new CourseModel();

        // Check if already evaluated
        if ($evaluationModel->alreadyEvaluated($userId, $teacherId, $courseId)) {
            return redirect()->to('/student/evaluate')
                             ->with('error', 'You have already evaluated this teacher for this course.');
        }

        $teacher = $userModel->find($teacherId);
        $course = $courseModel->find($courseId);
        $questions = $questionModel->getActiveWithCategory();

        if (!$teacher || !$course || empty($questions)) {
            return redirect()->to('/student/evaluate')
                             ->with('error', 'Unable to load evaluation form.');
        }

        $data = [
            'teacher'   => $teacher,
            'course'    => $course,
            'questions' => $questions,
        ];

        return view('student/evaluation_form', $data);
    }

    // Submit evaluation
    public function submitEvaluation(int $teacherId, int $courseId)
    {
        $userId = session()->get('user_id');
        
        $evaluationModel = new EvaluationModel();
        $answerModel = new AnswerModel();
        $questionModel = new QuestionModel();
        $pdfModel = new EvaluationPdfModel();
        $userModel = new UserModel();
        $courseModel = new CourseModel();

        // Double-check not already evaluated
        if ($evaluationModel->alreadyEvaluated($userId, $teacherId, $courseId)) {
            return redirect()->to('/student/evaluate')
                             ->with('error', 'You have already submitted this evaluation.');
        }

        // Get all active questions
        $questions = $questionModel->getActiveWithCategory();

        // Collect answers from POST
        $answers = [];
        foreach ($questions as $question) {
            $answer = [
                'question_id' => $question['id'],
                'score'       => null,
                'text_answer' => null,
            ];

            if ($question['type'] === 'scored') {
                $score = $this->request->getPost('question_' . $question['id']);
                $answer['score'] = $score ? (int)$score : null;
            } else {
                $textAnswer = $this->request->getPost('question_' . $question['id']);
                $answer['text_answer'] = $textAnswer ?: null;
            }

            $answers[] = $answer;
        }

        // Create evaluation record
        $evaluationId = $evaluationModel->insert([
            'student_id' => $userId,
            'teacher_id' => $teacherId,
            'course_id'  => $courseId,
            'status'     => 'submitted',
        ]);

        // Save all answers
        $answerModel->saveAnswers($evaluationId, $answers);

        // === GENERATE PDF ===
        $student = $userModel->find($userId);
        $teacher = $userModel->find($teacherId);
        $course = $courseModel->find($courseId);

        $html = $this->generateEvaluationPdfHtml($student, $teacher, $course, $questions, $answers);
        
        $pdfGenerator = new \App\Libraries\PdfGenerator();
        $filename = 'evaluation_' . $evaluationId . '_' . date('YmdHis') . '.pdf';
        $filePath = $pdfGenerator->generate($html, $filename);

        // Save PDF record to database
        $pdfModel->insert([
            'evaluation_id' => $evaluationId,
            'file_path'     => $filename,
            'generated_at'  => date('Y-m-d H:i:s'),
        ]);
        // === END PDF GENERATION ===

        return redirect()->to('/student/evaluate')
                         ->with('success', 'Evaluation submitted successfully!');
    }

    // View submitted evaluations
    public function myEvaluations(): string
    {
        $userId = session()->get('user_id');
        
        $evaluationModel = new EvaluationModel();
        $evaluations = $evaluationModel->getEvaluationsByStudent($userId);

        $data = [
            'evaluations' => $evaluations,
        ];

        return view('student/my_evaluations', $data);
    }

    // Helper method to generate PDF HTML content
    private function generateEvaluationPdfHtml($student, $teacher, $course, $questions, $answers): string
    {
        $html = '<!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; padding: 40px; }
                h1 { color: #6366f1; border-bottom: 2px solid #6366f1; padding-bottom: 10px; }
                .info { margin: 20px 0; padding: 15px; background: #f3f4f6; border-radius: 8px; }
                .info p { margin: 5px 0; }
                .question { margin: 20px 0; padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; }
                .question-text { font-weight: bold; margin-bottom: 10px; }
                .answer { color: #6366f1; font-weight: 600; }
                .rating { display: inline-block; padding: 5px 15px; background: #6366f1; color: #fff; border-radius: 4px; }
                .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 12px; }
            </style>
        </head>
        <body>
            <h1>Teacher Evaluation Report</h1>
            
            <div class="info">
                <p><strong>Teacher:</strong> ' . esc($teacher['name']) . '</p>
                <p><strong>Course:</strong> ' . esc($course['name']) . '</p>
                <p><strong>Student:</strong> ' . esc($student['name']) . '</p>
                <p><strong>Date:</strong> ' . date('F d, Y') . '</p>
            </div>

            <h2>Evaluation Responses</h2>';

        foreach ($questions as $index => $question) {
            $answer = $answers[$index] ?? null;
            $html .= '<div class="question">
                <div class="question-text">' . ($index + 1) . '. ' . esc($question['text']) . '</div>';
            
            if ($question['type'] === 'scored') {
                $score = $answer['score'] ?? 'N/A';
                $html .= '<div class="answer">Rating: <span class="rating">' . $score . '/5</span></div>';
            } else {
                $textAnswer = $answer['text_answer'] ?? 'No answer';
                $html .= '<div class="answer">Answer: ' . esc($textAnswer) . '</div>';
            }
            
            $html .= '</div>';
        }

        $html .= '<div class="footer">
            <p>Generated automatically by Teacher Evaluation Platform</p>
            <p>Generated on: ' . date('F d, Y \a\t H:i:s') . '</p>
        </div>
        </body>
        </html>';

        return $html;
    }
}
