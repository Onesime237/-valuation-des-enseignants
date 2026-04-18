<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Student extends Controller
{
    public function profile()
    {
        return view('student/profile');
    }

    public function teachers()
{
    // enseignants disponibles
    $data['teachers_to_evaluate'] = [
        ['id' => 1, 'name' => 'Dr Martin', 'course' => 'Programmation'],
        ['id' => 2, 'name' => 'Pr Alice', 'course' => 'Réseaux'],
        ['id' => 3, 'name' => 'Dr John', 'course' => 'Base de données'],
        ['id' => 4, 'name' => 'Dr Sophie', 'course' => 'Mathématiques'],
        ['id' => 5, 'name' => 'Pr Kevin', 'course' => 'IA'],
    ];

    // enseignants déjà évalués (simulation)
    $data['teachers_evaluated'] = [
        ['id' => 6, 'name' => 'Dr Paul', 'course' => 'Algorithmique'],
        ['id' => 7, 'name' => 'Pr Nadia', 'course' => 'Systèmes'],
    ];

    return view('student/teachers', $data);
}

    public function evaluate($teacher_id)
    {
        // pour l'instant on simule un enseignant
        $data['teacher'] = ['id' => $teacher_id, 'name' => 'Dr Martin', 'course' => 'Programmation'];
        return view('student/evaluate', $data);
    }
}