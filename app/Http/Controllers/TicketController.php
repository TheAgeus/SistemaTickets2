<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\ClienteTicket;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\ticketRegistrado;
use App\Mail\ticketAsignado;
use App\Mail\seHaIniciadoTuTicket;
use App\Mail\seHaCalificadoElTicket;

use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /* Vista de Tickets */
    public function tickets()
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $tickets = Ticket::all();
    
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

            // Validate the request data
            $validator = Validator::make($request->all(), [
                'titulo' => 'required|unique:tickets',
                'descripcion' => 'required',
                'prioridad' => 'required',
            ]);

            // Check if the validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $ticket = new Ticket;
            $ticket->titulo = $request->titulo;
            $ticket->descripcion = $request->descripcion;
            $ticket->prioridad = $request->prioridad;
            $ticket->timestamps = false;
            $ticket->cliente_id = Auth()->user()->id;
            $ticket->save();


            $data = [
                'ticket_id' => $ticket->id,
                'ticket_title' => $ticket->titulo,
                'ticket_descripcion' => $ticket->descripcion,
                'ticket_prioridad' => $ticket->prioridad,
                'ticket_tiempo_registro' => Carbon::now(),
                'cliente' => Auth()->user()->name
            ];
            

            $admin_mails = User::join('tipos', 'users.id', '=', 'tipos.user_id')
            ->where('tipos.rol', 'ADMIN')
            ->pluck('users.email')
            ->toArray();

            foreach($admin_mails as $mail) {
                try {
                    Mail::to($mail)->send(new ticketRegistrado($data));
                }
                catch (Exception $e){
                } 
            }


            return redirect()->back()->with('success', 'Ticket ' . $request->titulo . ' generado con éxito');  
        }
        else
        {
            return view('Forbbiden');
        }
    }

    public function ticketsClientes() // Aquí se regresan los tickets del cliente logueado
    {
        if(Auth()->user()->rol->rol == "CLIENTE"){
            $id = Auth()->user()->id;
            return view('ticketsCliente', [
                'tickets' => Ticket::where('cliente_id', $id)->get()
            ]);
        }
        else {
            return view('Forbbiden');
        }
    }

    /* Solo para controlar la ruta */
    public function empleadosTickets()
    {
        if(Auth()->user()->rol->rol != "EMPLEADO") {
            return view('Forbbiden');
        }
        return view('empleadosTickets');
    }

    // Aqui los empleados pueden filtrar sus tickets dependiendo del estado
    public function seleccionar_tickets(Request $request) 
    {
        if(Auth()->user()->rol->rol != "EMPLEADO") {
            return view('Forbbiden');
        }


        $wished_state = $request['estado_tickets'];

        if ($wished_state == "TODOS") {
            $pendingTickets = DB::table('ticket_empleado')
                ->select('ticket_id', 'titulo', 'descripcion', 'prioridad', 'estado')
                ->join('tickets', 'tickets.id', '=', 'ticket_empleado.ticket_id')
                ->join('users', 'users.id', '=', 'ticket_empleado.empleado_id')
                ->where('ticket_empleado.empleado_id', Auth()->user()->id)
                ->get();
        } else {
            $pendingTickets = DB::table('ticket_empleado')
            ->select('ticket_id', 'titulo', 'descripcion', 'prioridad', 'estado')
            ->join('tickets', 'tickets.id', '=', 'ticket_empleado.ticket_id')
            ->join('users', 'users.id', '=', 'ticket_empleado.empleado_id')
            ->where('ticket_empleado.empleado_id', Auth()->user()->id)
            ->where('tickets.estado', $wished_state)
            ->get();

        }

        return view('empleadosTickets', [
            'tickets' => $pendingTickets
        ]);
    }

    public function showTicket($id)
    {
        // Necesito la informacion del ticket
        $ticket = Ticket::find($id);

        // El nombre del cliente y su id de ese ticket
        $nombre_cliente = User::find($ticket->cliente_id)->name;
        $id_cliente = $ticket->cliente_id;

        // Todos los empleados asignados al ticket
        $empleados_asignados = DB::table('ticket_empleado')
            ->join('users', 'users.id', 'ticket_empleado.empleado_id')
            ->where('ticket_empleado.ticket_id', $id)
            ->get();

        // Todos los empleados no asignados al ticket
        /*$empleados_no_asignados = DB::table('ticket_empleado')
            ->join('users', 'users.id', 'ticket_empleado.empleado_id')
            ->where('ticket_empleado.ticket_id', '!=', $id)
            ->get();*/
        $empleados_no_asignados = DB::table('ticket_empleado')
            ->select('ticket_empleado.empleado_id', 'users.name', 'users.rfc', DB::raw('COUNT(ticket_empleado.ticket_id) as num_tickets_assigned'))
            ->join('users', 'users.id', 'ticket_empleado.empleado_id')
            ->groupBy('ticket_empleado.empleado_id', 'users.name')
            ->where('ticket_empleado.ticket_id', '!=', $id)
            ->get();

        return view('showTicket', [
            'nombre_cliente' => $nombre_cliente,
            'id_cliente' => $id_cliente,
            'ticketData' => $ticket->toArray(),
            'empleados' => $empleados_no_asignados, // empleados no asignados al ticket
            'empleados_asignados' => $empleados_asignados // empleados asignados al ticket
        ]);
    }

    public function iniciarTicket($id) 
    {
        if(Auth()->user()->rol->rol == "EMPLEADO") // Solo los empleados pueden iniciar tickets
        {
            // Verificar si ese ticket si esta asignado a el usuario autenticado
            $isMyTicket = DB::table('ticket_empleado')
                ->where('empleado_id', Auth()->user()->id)
                ->where('ticket_id', $id)
                ->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($id);
                if($ticket->estado == "PENDIENTE")
                {
                    $client_email = User::select('email')->join('tickets', 'tickets.cliente_id', 'users.id')->where('tickets.id', '=',  $id)->get();
                    
                    $data = [
                        'ticket_title' => $ticket->titulo,
                        'nombre_empleado' => Auth()->user()->name,
                        'cambio_estado' => "INICIADO"
                    ];
                    
                    $ticket->estado = "EN PROCESO";
                    $ticket->tiempo_inicio = Carbon::now();
                    $ticket->save();
                    
                    // send mail to client, maybe to admin
                    Mail::to($client_email)->send(new seHaIniciadoTuTicket($data));
                    
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
            $isMyTicket = DB::table('ticket_empleado')
                ->where('empleado_id', Auth()->user()->id)
                ->where('ticket_id', $id)
                ->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($id);
                if($ticket->estado == "EN PROCESO")
                {
                    $client_email = User::select('email')->join('tickets', 'tickets.cliente_id', 'users.id')->where('tickets.id', '=',  $id)->get();
                    
                    $data = [
                        'ticket_title' => $ticket->titulo,
                        'nombre_empleado' => Auth()->user()->name,
                        'cambio_estado' => "TERMINADO"
                    ];

                    $ticket->estado = "TERMINADO";
                    $ticket->tiempo_final = Carbon::now();
                    $ticket->save();
                    
                    // send mail to client, maybe to admin
                    Mail::to($client_email)->send(new seHaIniciadoTuTicket($data));

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
            $isMyTicket = Ticket::where('cliente_id', '=', Auth()->user()->id)
                ->where('id', '=', $request['ticket_id'])->exists();
            
            if($isMyTicket) // Cambiar el estado a EN PROCESO, insertar tiempo_inicio 
            {
                $ticket = Ticket::find($request['ticket_id']);
                if($ticket->estado == "TERMINADO")
                {
                    
                    $ticket->estado = "CALIFICADO";
                    $ticket->como_fue_servicio = $request['como_fue_servicio'];
                    $ticket->observaciones = $request['observaciones'];
                    $ticket->save();
                    
                    $empleados_asignados = DB::table('ticket_empleado')
                        ->join('users', 'users.id', 'ticket_empleado.empleado_id')
                        ->where('ticket_empleado.ticket_id', $request['ticket_id'])
                        ->get();
                    
                    $admin_mails = User::join('tipos', 'users.id', '=', 'tipos.user_id')
                        ->where('tipos.rol', 'ADMIN')
                        ->pluck('users.email')
                        ->toArray();
                        
                    $data = [
                        'ticket_title' => $ticket->titulo,
                        'nombres_empleados' => $empleados_asignados->pluck('name'),
                        'como_fue_servicio' => $request['como_fue_servicio'],
                        'observaciones' => $request['observaciones']
                    ];

                    foreach($admin_mails as $mail) {
                        try {
                            Mail::to($mail)->send(new seHaCalificadoElTicket($data));
                        }
                        catch (Exception $e){} 
                    }
                    foreach($empleados_asignados->pluck('email') as $mail) {
                        Mail::to($mail)->send(new seHaCalificadoElTicket($data));
                    }


                    return redirect()->back();
                }
            }
        }
    }
    public function ticketAsignarEmpleados(Request $request) 
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $ticket_id = $request->get('ticket_id'); // ticket id
            $request = $request->except('_token', 'ticket_id'); // ids de los empleados
            $cliente_id = Ticket::select('cliente_id')->where('id', $ticket_id)->get(); // get cliente_id
            $estado_ticket = Ticket::select('estado')->where('id', $ticket_id)->get(); // get estado

            $empleados_ids = [];

            foreach($request as $empleado_id) {
                array_push($empleados_ids, $empleado_id);
                $assign = new ClienteTicket();
                $assign->cliente_id = $cliente_id;
                $assign->empleado_id = $empleado_id;
                $assign->ticket_id = $ticket_id;
                $assign->save();
            }

            $empleados_names = User::whereIn('id', $empleados_ids)->pluck('name');

            $empleados = User::whereIn('id', $empleados_ids)->get();
            $cliente = User::where('id', $cliente_id)->get()[0];
            $cliente_mail = $cliente->email;
            $cliente_name = $cliente->name;
            $empleados_names = $empleados->pluck('name')->toArray();
            $empleados_emails = $empleados->pluck('email')->toArray();
            $ticket = Ticket::find($ticket_id)->get()[0];
            $data = [
                'cliente_name' => $cliente_name,
                'empleados_names' => $empleados_names,
                'ticket_id' => $ticket_id,
                'ticket_title' => $ticket->titulo,
                'ticket_descripcion' => $ticket->descripcion,
                'ticket_prioridad' => $ticket->prioridad,
                'ticket_tiempo_registro' => $ticket->tiempo_registro,
            ];  

          
            foreach($empleados_emails as $mail) {
                try {
                    Mail::to($mail)->send(new ticketAsignado($data));
                }
                catch (Exception $e){

                }   
            }
            Mail::to($cliente_mail)->send(new ticketAsignado($data));


            return redirect()->back()->with('success', 'Empleados ' . implode(", ", $empleados_names) . ' asignados al ticket');  

        }
        else 
        {
            return view('Forbbiden');
        }
        
    }
    
    /* Se agregara un empleado */
    

    public function show_descargar_excel() {
        return view('descargar_excel');
    }

    public function testxd(){
        
        return Hash::make("Fiscal23.");
    }
}
