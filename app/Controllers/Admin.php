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
}