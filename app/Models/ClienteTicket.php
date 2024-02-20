<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteTicket extends Model
{
    use HasFactory;

    protected $table = 'ticket_user';

    protected $fillable = [
        'ticket_id',
        'cliente_id',
        'empleado_id',
    ];
}