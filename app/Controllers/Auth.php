<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    // Shows the login page
    public function index(): string|RedirectResponse
    {
        // If already logged in, redirect to the right dashboard
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('user_role'));
        }

        return view('auth/login');
    }

    // Handles the login form submission
    public function login(): RedirectResponse
    {
        $rules = [
            'identifier' => 'required',
            'password'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $identifier = trim($this->request->getPost('identifier'));
        $password   = $this->request->getPost('password');

        $model = new UserModel();

        // Try email first, then matricule (students only)
        $user = $model->findByEmail($identifier)
               ?? $model->findByMatricule($identifier);


        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Incorrect identifier or password.');
        }

        // Store user data in session
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);

        return $this->redirectByRole($user['role']);
    }

    // Destroys the session and sends everyone back to login
    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/login')
                         ->with('success', 'You have been logged out.');
    }

    // ── Private helper ────────────────────────────────────────────────────────

    private function redirectByRole(string $role): RedirectResponse
    {
        return match ($role) {
            'admin'   => redirect()->to('/admin/dashboard'),
            'teacher' => redirect()->to('/teacher/dashboard'),
            'student' => redirect()->to('/student/dashboard'),
            default   => redirect()->to('/login'),
        };
    }
}