<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\TeacherCourseModel;
use App\Models\QuestionModel;
use App\Models\EvaluationModel;
use App\Models\AnswerModel;
use App\Models\UserModel;

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
}
