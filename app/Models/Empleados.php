<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = 'empleados';
    protected $fillable = ['tipo_doc', 'nombre', 'documento', 'cargo', 'departamento', 'direccion', 'email', 'fecha_nacimiento', 'telefono', 'estado'];

}
