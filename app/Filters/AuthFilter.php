<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Not logged in — send to login page
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')
                             ->with('error', 'Please log in to access this page.');
        }

        // Role check — only runs when a role is specified e.g. 'auth:admin'
        if (! empty($arguments)) {
            $requiredRole = $arguments[0];
            $userRole     = session()->get('user_role');

            if ($userRole !== $requiredRole) {
                return redirect()->to($this->dashboardForRole($userRole))
                                 ->with('error', 'Unauthorized access.');
            }
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }

    // ── Private helper ────────────────────────────────────────────────────────

    private function dashboardForRole(string $role): string
    {
        return match ($role) {
            'admin'   => '/admin/dashboard',
            'teacher' => '/teacher/dashboard',
            'student' => '/student/dashboard',
            default   => '/login',
        };
    }
}