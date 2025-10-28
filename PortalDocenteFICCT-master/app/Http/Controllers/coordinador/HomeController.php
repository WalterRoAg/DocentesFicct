<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\Grupo;
use App\Models\Materia;
use App\Models\Asistencia;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'aulas'       => Aula::count(),
            'grupos'      => Grupo::count(),
            'materias'    => Materia::count(),
            'asistencias' => Asistencia::count(),
        ];

        return view('coordinador.dashboard', compact('stats'));
    }
}
