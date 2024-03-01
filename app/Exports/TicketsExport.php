<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, ShouldAutoSize, WithHeadings
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $request = $this->request;

        $estadoPendiente = $request->input('estadoPendiente');
        $estadoEnProceso = $request->input('estadoEnProceso');
        $estadoTerminado = $request->input('estadoTerminado');
        $estadoCalificado = $request->input('estadoCalificado');
        $prioridadMuyAlta = $request->input('prioridadMuyAlta');
        $prioridadAlta = $request->input('prioridadAlta');
        $prioridadMedia = $request->input('prioridadMedia');
        $prioridadMediaBaja = $request->input('prioridadMediaBaja');
        $prioridadBaja = $request->input('prioridadBaja');
        $titulo = $request->input('titulo');
        $fecha_registro = $request->input('fecha_registro');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');
        $anio = $request->input('anio');
        $mes = $request->input('mes');

        $tickets = Ticket::query();

        if ($estadoPendiente) {
            $tickets->where('estado', 'PENDIENTE');
        }
        
        if ($estadoEnProceso) {
            $tickets->orWhere('estado', 'EN PROCESO');
        }
        
        if ($estadoTerminado) {
            $tickets->orWhere('estado', 'TERMINADO');
        }
        
        if ($estadoCalificado) {
            $tickets->orWhere('estado', 'CALIFICADO');
        }
        
        if ($prioridadMuyAlta) {
            $tickets->where('prioridad', 'MUY ALTA');
        }
        
        if ($prioridadAlta) {
            $tickets->Where('prioridad', 'ALTA');
        }
        
        if ($prioridadMedia) {
            $tickets->Where('prioridad', 'MEDIA');
        }
        
        if ($prioridadMediaBaja) {
            $tickets->Where('prioridad', 'MEDIA BAJA');
        }
        
        if ($prioridadBaja) {
            $tickets->Where('prioridad', 'BAJA');
        }
        
        if ($titulo) {
            $tickets->Where('titulo', 'like', $titulo);
        }
        
        if ($fecha_registro) {
            $tickets->WhereDate('tiempo_registro', $fecha_registro);
        }
        
        if ($fecha_inicio) {
            $tickets->WhereDate('tiempo_inicio', $fecha_inicio);
        }
        
        if ($fecha_final) {
            $tickets->WhereDate('tiempo_final', $fecha_final);
        }
        
        if ($anio) {
            $tickets->WhereYear('tiempo_registro', $anio);
        }
        
        if ($mes) {
            $tickets->WhereMonth('tiempo_registro', $mes);
        }
        
        $tickets->join('users', 'users.id', '=', 'tickets.cliente_id')
            ->select('tickets.*', 'users.name as client_name');
        $tickets = $tickets->get();
                            

        return $tickets;
    }

    public function headings(): array
    {
        return [
            'id',
            'titulo',
            'descripcion',
            'prioridad',
            'estado',
            'tiempo_registro',
            'tiempo_inicio',
            'tiempo_final',
            'como_fue_servicio',
            'observaciones',
            'client_id',
            'client_name'
        ];
    }
}
