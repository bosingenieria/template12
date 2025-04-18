<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['tipo_doc', 'documento_identidad', 'nombre', 'apellido', 'email', 'telefono_principal', 'telefono_secundario', 'direccion_principal', 'direccion_secundaria', 'estado'];
}
