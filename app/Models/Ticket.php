<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'tiempo_registro',
        'tiempo_inicio',
        'tiempo_final',
        'como_fue_servicio',
        'observaciones'
    ];
}
