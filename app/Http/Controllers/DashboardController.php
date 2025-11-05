<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;

class DashboardController extends Controller
{
   public function index()
{
    $hoy = now();

    $stats = [
        'ninos' => Paciente::where('sexo', 'Masculino')
            ->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, ?) < 18', [$hoy])
            ->count(),
        'ninas' => Paciente::where('sexo', 'Femenino')
            ->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, ?) < 18', [$hoy])
            ->count(),
        'hombres' => Paciente::where('sexo', 'Masculino')
            ->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, ?) >= 18', [$hoy])
            ->count(),
        'mujeres' => Paciente::where('sexo', 'Femenino')
            ->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, ?) >= 18', [$hoy])
            ->count(),
    ];

    return view('dashboard', compact('stats'));
}
}
