<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\ClienteTicket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketController extends Controller
{
    /* Vista de Tickets */
    public function tickets()
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $tickets = Ticket::paginate(20);
    
            return view("tickets", [
                'tickets' => $tickets
            ]);
        }
        else
        {
            return view('Forbbiden');
        }
    }

    public function ticketsClientesAddTicket()
    {
        if(Auth()->user()->rol->rol == "CLIENTE")
        {
            return view('addTicketPage');
        }
    } 

    public function ticketsClientesAddTicketPost(Request $request) 
    {
        if(Auth()->user()->rol->rol == "CLIENTE")
        {
            $ticket = new Ticket;
            $ticket->titulo = $request->titulo;
            $ticket->descripcion = $request->descripcion;
            $ticket->prioridad = $request->prioridad;
            $ticket->timestamps = false;
            $ticket->save();

            DB::table('ticket_user')->insert([
                'cliente_id' => $request->user_id,
                'ticket_id' => $ticket->id
            ]);

            return redirect()->back()->with('success', 'Ticket ' . $request->titulo . ' generado con éxito');  
        }
        else
        {
            return view('Forbbiden');
        }
    }

    public function ticketsClientes() 
    {
        if(Auth()->user()->rol->rol == "CLIENTE")
        {
            $id = Auth()->user()->id;
            $tickets = DB::table('ticket_user')
                ->join('tickets', 'tickets.id', '=', 'ticket_user.ticket_id')
                ->join('users', 'users.id', '=', 'ticket_user.cliente_id')
                ->get();

            return view('ticketsCliente', [
                'tickets' => $tickets
            ]);
        }
        else 
        {
            return view('Forbbiden');
        }
    }

    /* Solo para controlar la ruta */
    public function empleadosTickets()
    {
        if(Auth()->user()->rol->rol != "EMPLEADO") 
        {
            return view('Forbbiden');
        }

        return view('empleadosTickets');
    }

    public function seleccionar_tickets(Request $request)
    {
        $wished_state = $request['estado_tickets'];
        $user_id = $request['user_id'];

        if ($wished_state == "TODOS") {
            $pendingTickets = ClienteTicket::select('ticket_id', 'titulo', 'descripcion', 'prioridad', 'estado')
            ->join('tickets', 'ticket_user.ticket_id', '=', 'tickets.id')
            ->where('empleado_id', $user_id)
            ->get();
        } else {
            $pendingTickets = ClienteTicket::select('ticket_id', 'titulo', 'descripcion', 'prioridad', 'estado')
            ->join('tickets', 'ticket_user.ticket_id', '=', 'tickets.id')
            ->where('empleado_id', $user_id)
            ->where('estado', $wished_state)
            ->get();
        }

        return view('empleadosTickets', [
            'tickets' => $pendingTickets
        ]);
    }

    public function showTicket($id)
    {

        $ticketData = ClienteTicket::select(
            'tickets.id',
            'tickets.titulo',
            'tickets.descripcion',
            'tickets.prioridad',
            'tickets.estado',
            'tickets.tiempo_registro',
            'tickets.tiempo_inicio',
            'tickets.tiempo_final',
            'tickets.como_fue_servicio',
            'tickets.observaciones',
            'ticket_user.cliente_id',
            'ticket_user.empleado_id',
            'u_cliente.name as cliente_name',
            'u_cliente.id as cliente_id',
            'u_empleado.name as empleado_name',
            'u_empleado.id as empleado_id'
        )
        ->join('tickets', 'ticket_user.ticket_id', '=', 'tickets.id')
        ->join('users as u_cliente', 'ticket_user.cliente_id', '=', 'u_cliente.id')
        ->leftJoin('users as u_empleado', 'ticket_user.empleado_id', '=', 'u_empleado.id')
        ->where('ticket_user.ticket_id', $id)
        ->get();

        return view('showTicket', [
            'ticketData' => $ticketData->toArray()[0]
        ]);
    }

    public function iniciarTicket($id) 
    {
        if(Auth()->user()->rol->rol == "EMPLEADO") // Solo los empleados pueden iniciar tickets
        {
            // Verificar si ese ticket si esta asignado a el usuario autenticado
            $isMyTicket = ClienteTicket::where('empleado_id', Auth()->user()->id)
                ->where('ticket_id', $id)
                ->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($id);
                if($ticket->estado == "PENDIENTE")
                {
                    $ticket->estado = "EN PROCESO";
                    $ticket->tiempo_inicio = Carbon::now();
                    $ticket->save();
    
                    return redirect()->back();
                }
            }
        }
    }
    public function terminarTicket($id) 
    {
        if(Auth()->user()->rol->rol == "EMPLEADO") // Solo los empleados pueden iniciar tickets
        {
            // Verificar si ese ticket si esta asignado a el usuario autenticado
            $isMyTicket = ClienteTicket::where('empleado_id', Auth()->user()->id)
                ->where('ticket_id', $id)
                ->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($id);
                if($ticket->estado == "EN PROCESO")
                {
                    $ticket->estado = "TERMINADO";
                    $ticket->tiempo_final = Carbon::now();
                    $ticket->save();
    
                    return redirect()->back();
                }
            }
        }
    }
    public function calificarTicket(Request $request) 
    {
        $request = $request->except('_token');

        if(Auth()->user()->rol->rol == "CLIENTE") // Solo los clientes pueden calificar tickets
        {
            // Verificar si ese ticket si esta asignado a el usuario autenticado
            $isMyTicket = ClienteTicket::where('cliente_id', Auth()->user()->id)
                ->where('ticket_id', $request['ticket_id'])
                ->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($request['ticket_id']);
                if($ticket->estado == "TERMINADO")
                {
                    $ticket->estado = "CALIFICADO";
                    $ticket->como_fue_servicio = $request['como_fue_servicio'];
                    $ticket->observaciones = $request['observaciones'];
                    $ticket->save();
    
                    return redirect()->back();
                }
            }
        }
    }
}
