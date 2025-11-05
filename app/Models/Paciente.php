<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'sexo',
        'numero_expediente',
        'localidad',
        'fecha_nacimiento',
        'direccion',
        'municipio',
        'fecha_ingreso',
        'fecha_consulta',
        'seccion',
        'nivel',
        'departamento',
    ];
}
