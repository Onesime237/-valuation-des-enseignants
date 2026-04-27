<?php

namespace App\Controllers;

use App\Models\UserModel;

class Admin extends BaseController
{
    // ── Dashboard ─────────────────────────────────────────────────────────────

public function index(): string
{
    $model = new UserModel();

    $data = [
        'user_name'      => session()->get('user_name'),
        'user_email'     => session()->get('user_email'),
        'total_teachers' => $model->where('role', 'teacher')->countAllResults(),
        'total_students' => $model->where('role', 'student')->countAllResults(),
    ];

    return view('admin/dashboard', $data);
}

    // ── Teachers ──────────────────────────────────────────────────────────────

    public function teachers(): string
    {
        $model = new UserModel();
        $data  = [
            'teachers' => $model->where('role', 'teacher')->findAll(),
        ];

        return view('admin/teachers/index', $data);
    }

    public function createTeacher(): string
    {
        return view('admin/teachers/create');
    }

    public function storeTeacher()
    {
        $rules = [
            'name'     => 'required|min_length[2]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $model->skipValidation(true)->insert([
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'teacher',
            'is_active' => 1,
        ]);

        return redirect()->to('/admin/teachers')
                         ->with('success', 'Teacher account created successfully.');
    }

    public function editTeacher(int $id): string
    {
        $model   = new UserModel();
        $teacher = $model->find($id);

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        return view('admin/teachers/edit', ['teacher' => $teacher]);
    }

    public function updateTeacher(int $id)
    {
        $model   = new UserModel();
        $teacher = $model->find($id);

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // Only update password if a new one was provided
        $newPassword = $this->request->getPost('password');
        if (! empty($newPassword)) {
            $updateData['password'] = $newPassword;
        }

        $model->skipValidation(true)->update($id, $updateData);

        return redirect()->to('/admin/teachers')
                         ->with('success', 'Teacher updated successfully.');
    }

    public function toggleTeacher(int $id)
    {
        $model   = new UserModel();
        $teacher = $model->find($id);

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        $model->update($id, [
            'is_active' => $teacher['is_active'] ? 0 : 1,
        ]);

        $status = $teacher['is_active'] ? 'deactivated' : 'activated';

        return redirect()->to('/admin/teachers')
                         ->with('success', "Teacher {$status} successfully.");
    }

    public function deleteTeacher(int $id)
    {
        $model   = new UserModel();
        $teacher = $model->find($id);

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        $model->delete($id);

        return redirect()->to('/admin/teachers')
                         ->with('success', 'Teacher deleted successfully.');
    }

    // ── Students ──────────────────────────────────────────────────────────────

    public function students(): string
    {
        $model = new UserModel();
        $data  = [
            'students' => $model->where('role', 'student')->findAll(),
        ];

        return view('admin/students/index', $data);
    }

    public function createStudent(): string
    {
        return view('admin/students/create');
    }

    public function storeStudent()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'email'      => 'required|valid_email|is_unique[users.email]',
            'matricule'  => 'required|is_unique[users.matricule]',
            'password'   => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $model->skipValidation(true)->insert([
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'matricule' => $this->request->getPost('matricule'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'student',
            'is_active' => 1,
        ]);

        return redirect()->to('/admin/students')
                         ->with('success', 'Student account created successfully.');
    }

    public function editStudent(int $id): string
    {
        $model   = new UserModel();
        $student = $model->find($id);

        if (! $student || $student['role'] !== 'student') {
            return redirect()->to('/admin/students')
                             ->with('error', 'Student not found.');
        }

        return view('admin/students/edit', ['student' => $student]);
    }

    public function updateStudent(int $id)
    {
        $model   = new UserModel();
        $student = $model->find($id);

        if (! $student || $student['role'] !== 'student') {
            return redirect()->to('/admin/students')
                             ->with('error', 'Student not found.');
        }

        $rules = [
            'name'      => 'required|min_length[2]|max_length[100]',
            'email'     => "required|valid_email|is_unique[users.email,id,{$id}]",
            'matricule' => "required|is_unique[users.matricule,id,{$id}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'matricule' => $this->request->getPost('matricule'),
        ];

        $newPassword = $this->request->getPost('password');
        if (! empty($newPassword)) {
            $updateData['password'] = $newPassword;
        }

        $model->skipValidation(true)->update($id, $updateData);

        return redirect()->to('/admin/students')
                         ->with('success', 'Student updated successfully.');
    }

    public function toggleStudent(int $id)
    {
        $model   = new UserModel();
        $student = $model->find($id);

        if (! $student || $student['role'] !== 'student') {
            return redirect()->to('/admin/students')
                             ->with('error', 'Student not found.');
        }

        $model->update($id, [
            'is_active' => $student['is_active'] ? 0 : 1,
        ]);

        $status = $student['is_active'] ? 'deactivated' : 'activated';

        return redirect()->to('/admin/students')
                         ->with('success', "Student {$status} successfully.");
    }

    public function deleteStudent(int $id)
    {
        $model   = new UserModel();
        $student = $model->find($id);

        if (! $student || $student['role'] !== 'student') {
            return redirect()->to('/admin/students')
                             ->with('error', 'Student not found.');
        }

        $model->delete($id);

        return redirect()->to('/admin/students')
                         ->with('success', 'Student deleted successfully.');
    }
    // ── Courses ───────────────────────────────────────────────────────────────

    public function courses(): string
    {
        $courseModel = new \App\Models\CourseModel();
        $data = [
            'courses' => $courseModel->findAll(),
        ];

        return view('admin/courses/index', $data);
    }

    public function createCourse(): string
    {
        return view('admin/courses/create');
    }

    public function storeCourse()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $courseModel = new \App\Models\CourseModel();
        $courseModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'is_active'   => 1,
        ]);

        return redirect()->to('/admin/courses')
                         ->with('success', 'Course created successfully.');
    }

    public function editCourse(int $id): string
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($id);

        if (! $course) {
            return redirect()->to('/admin/courses')
                             ->with('error', 'Course not found.');
        }

        return view('admin/courses/edit', ['course' => $course]);
    }

    public function updateCourse(int $id)
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($id);

        if (! $course) {
            return redirect()->to('/admin/courses')
                             ->with('error', 'Course not found.');
        }

        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $courseModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/courses')
                         ->with('success', 'Course updated successfully.');
    }

    public function toggleCourse(int $id)
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($id);

        if (! $course) {
            return redirect()->to('/admin/courses')
                             ->with('error', 'Course not found.');
        }

        $courseModel->update($id, ['is_active' => $course['is_active'] ? 0 : 1]);
        $status = $course['is_active'] ? 'deactivated' : 'activated';

        return redirect()->to('/admin/courses')
                         ->with('success', "Course {$status} successfully.");
    }

    public function deleteCourse(int $id)
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($id);

        if (! $course) {
            return redirect()->to('/admin/courses')
                             ->with('error', 'Course not found.');
        }

        $courseModel->delete($id);

        return redirect()->to('/admin/courses')
                         ->with('success', 'Course deleted successfully.');
    }

    // ── Teacher-Course Assignments ────────────────────────────────────────────

    public function assignCourses(int $teacherId): string
    {
        $userModel         = new \App\Models\UserModel();
        $courseModel       = new \App\Models\CourseModel();
        $teacherCourseModel = new \App\Models\TeacherCourseModel();

        $teacher        = $userModel->find($teacherId);
        $allCourses     = $courseModel->getActiveCourses();
        $assignedCourses = $teacherCourseModel->getCoursesForTeacher($teacherId);
        $assignedIds    = array_column($assignedCourses, 'id');

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        return view('admin/teachers/assign_courses', [
            'teacher'      => $teacher,
            'allCourses'   => $allCourses,
            'assignedIds'  => $assignedIds,
        ]);
    }

    public function saveAssignments(int $teacherId)
    {
        $userModel          = new \App\Models\UserModel();
        $teacherCourseModel = new \App\Models\TeacherCourseModel();

        $teacher = $userModel->find($teacherId);

        if (! $teacher || $teacher['role'] !== 'teacher') {
            return redirect()->to('/admin/teachers')
                             ->with('error', 'Teacher not found.');
        }

        // Delete all existing assignments for this teacher, then re-insert
        $teacherCourseModel->where('teacher_id', $teacherId)->delete();

        $selectedCourses = $this->request->getPost('courses') ?? [];

        foreach ($selectedCourses as $courseId) {
            $teacherCourseModel->insert([
                'teacher_id' => $teacherId,
                'course_id'  => (int) $courseId,
            ]);
        }

        return redirect()->to('/admin/teachers')
                         ->with('success', 'Course assignments updated successfully.');
    }



    // ── Categories ────────────────────────────────────────────────────────────

    public function categories(): string
    {
        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'categories' => $categoryModel->findAll(),
        ];

        return view('admin/categories/index', $data);
    }

    public function createCategory(): string
    {
        return view('admin/categories/create');
    }

    public function storeCategory()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $categoryModel = new \App\Models\CategoryModel();
        $categoryModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/categories')
                         ->with('success', 'Category created successfully.');
    }

    public function editCategory(int $id): string
    {
        $categoryModel = new \App\Models\CategoryModel();
        $category = $categoryModel->find($id);

        if (! $category) {
            return redirect()->to('/admin/categories')
                             ->with('error', 'Category not found.');
        }

        return view('admin/categories/edit', ['category' => $category]);
    }

    public function updateCategory(int $id)
    {
        $categoryModel = new \App\Models\CategoryModel();
        $category = $categoryModel->find($id);

        if (! $category) {
            return redirect()->to('/admin/categories')
                             ->with('error', 'Category not found.');
        }

        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'description' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $categoryModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/admin/categories')
                         ->with('success', 'Category updated successfully.');
    }

    public function deleteCategory(int $id)
    {
        $categoryModel = new \App\Models\CategoryModel();
        $category = $categoryModel->find($id);

        if (! $category) {
            return redirect()->to('/admin/categories')
                             ->with('error', 'Category not found.');
        }

        $categoryModel->delete($id);

        return redirect()->to('/admin/categories')
                         ->with('success', 'Category deleted successfully.');
    }

    // ── Questions ─────────────────────────────────────────────────────────────

    public function questions(): string
    {
        $questionModel = new \App\Models\QuestionModel();
        $data = [
            'questions' => $questionModel->getAllWithCategory(),
        ];

        return view('admin/questions/index', $data);
    }

    public function createQuestion(): string
    {
        $categoryModel = new \App\Models\CategoryModel();
        $data = [
            'categories' => $categoryModel->getDropdown(),
        ];

        return view('admin/questions/create', $data);
    }

    public function storeQuestion()
    {
        $rules = [
            'text'        => 'required|min_length[5]',
            'type'        => 'required|in_list[scored,open]',
            'category_id' => 'permit_empty|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $questionModel = new \App\Models\QuestionModel();
        $questionModel->insert([
            'text'        => $this->request->getPost('text'),
            'type'        => $this->request->getPost('type'),
            'category_id' => $this->request->getPost('category_id') ?: null,
            'is_active'   => 1,
        ]);

        return redirect()->to('/admin/questions')
                         ->with('success', 'Question created successfully.');
    }

    public function editQuestion(int $id): string
    {
        $questionModel = new \App\Models\QuestionModel();
        $categoryModel = new \App\Models\CategoryModel();

        $question = $questionModel->find($id);

        if (! $question) {
            return redirect()->to('/admin/questions')
                             ->with('error', 'Question not found.');
        }

        return view('admin/questions/edit', [
            'question'   => $question,
            'categories' => $categoryModel->getDropdown(),
        ]);
    }

    public function updateQuestion(int $id)
    {
        $questionModel = new \App\Models\QuestionModel();
        $question = $questionModel->find($id);

        if (! $question) {
            return redirect()->to('/admin/questions')
                             ->with('error', 'Question not found.');
        }

        $rules = [
            'text'        => 'required|min_length[5]',
            'type'        => 'required|in_list[scored,open]',
            'category_id' => 'permit_empty|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $questionModel->update($id, [
            'text'        => $this->request->getPost('text'),
            'type'        => $this->request->getPost('type'),
            'category_id' => $this->request->getPost('category_id') ?: null,
        ]);

        return redirect()->to('/admin/questions')
                         ->with('success', 'Question updated successfully.');
    }

    public function toggleQuestion(int $id)
    {
        $questionModel = new \App\Models\QuestionModel();
        $question = $questionModel->find($id);

        if (! $question) {
            return redirect()->to('/admin/questions')
                             ->with('error', 'Question not found.');
        }

        $questionModel->update($id, ['is_active' => $question['is_active'] ? 0 : 1]);
        $status = $question['is_active'] ? 'deactivated' : 'activated';

        return redirect()->to('/admin/questions')
                         ->with('success', "Question {$status} successfully.");
    }

    public function deleteQuestion(int $id)
    {
        $questionModel = new \App\Models\QuestionModel();
        $question = $questionModel->find($id);

        if (! $question) {
            return redirect()->to('/admin/questions')
                             ->with('error', 'Question not found.');
        }

        $questionModel->delete($id);

        return redirect()->to('/admin/questions')
                         ->with('success', 'Question deleted successfully.');
    }
}