<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Usuario,Rol,Permiso,Docente};
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'usuarios' => Usuario::count(),
            'roles' => Rol::count(),
            'docentes' => Docente::count(),
            'asistencias_hoy' => DB::table('asistencias')->whereDate('fecha_hora', now())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
