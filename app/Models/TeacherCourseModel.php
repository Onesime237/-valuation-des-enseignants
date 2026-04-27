<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherCourseModel extends Model
{
    protected $table            = 'teacher_courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'teacher_id',
        'course_id',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get all courses assigned to a specific teacher
    public function getCoursesForTeacher(int $teacherId): array
    {
        return $this->db->table('teacher_courses tc')
                        ->select('courses.id, courses.name, courses.description')
                        ->join('courses', 'courses.id = tc.course_id')
                        ->where('tc.teacher_id', $teacherId)
                        ->where('courses.is_active', 1)
                        ->get()
                        ->getResultArray();
    }

    // Get all teachers assigned to a specific course
    public function getTeachersForCourse(int $courseId): array
    {
        return $this->db->table('teacher_courses tc')
                        ->select('users.id, users.name, users.email')
                        ->join('users', 'users.id = tc.teacher_id')
                        ->where('tc.course_id', $courseId)
                        ->where('users.is_active', 1)
                        ->get()
                        ->getResultArray();
    }

    // Check if a teacher is already assigned to a course
    public function isAssigned(int $teacherId, int $courseId): bool
    {
        return $this->where('teacher_id', $teacherId)
                    ->where('course_id', $courseId)
                    ->countAllResults() > 0;
    }

    // Remove a specific assignment
    public function removeAssignment(int $teacherId, int $courseId): void
    {
        $this->where('teacher_id', $teacherId)
             ->where('course_id', $courseId)
             ->delete();
    }
}