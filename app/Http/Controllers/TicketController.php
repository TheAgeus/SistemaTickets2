<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

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

            DB::table('ticket_empleado')->insert([
                'user_id' => $request->user_id,
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
            $tickets = Ticket::select(['*'])
                ->join('ticket_empleado', 'ticket_empleado.ticket_id', '=', 'ticket_empleado')
        }
    }
}
