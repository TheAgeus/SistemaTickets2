<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\ClienteTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\ticketAsignado;
use App\Mail\tuTicketFueAsignadoA;
use App\Mail\teFueronAsignadosTickets;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserController extends Controller
{
    /* MÉTODOS PARA USUARIOS TIPO ADMIN */
    /* MÉTODOS PARA VER Y MANIPULAR USUARIOS EMPLEADOS */
    public function empleados() 
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $empleados = User::select(['id', 'name', 'email', 'rfc'])
                ->join('tipos', 'tipos.user_id', '=', 'users.id')
                ->where('tipos.rol', 'EMPLEADO')
                ->where('users.habilitado', 1)
                ->paginate(15);
            $empleados_deshabilitados = User::select(['id', 'name', 'email', 'rfc'])
                ->join('tipos', 'tipos.user_id', '=', 'users.id')
                ->where('tipos.rol', 'EMPLEADO')
                ->where('users.habilitado', 0)
                ->paginate(15);
            $tickets = DB::table('ticket_empleado')
                ->select('tickets.*', DB::raw('GROUP_CONCAT(ticket_empleado.empleado_id SEPARATOR ",") as empleados_asignados'))
                ->join('tickets', 'tickets.id', '=', 'ticket_empleado.ticket_id')
                ->groupBy('ticket_empleado.ticket_id')
                ->get();
        
    
            return view("empleados", [
                'empleados' => $empleados,
                'empleadosDeshabilitados' => $empleados_deshabilitados,
                'tickets' => $tickets
            ]);
        }
        else 
        {
            return view('Forbbiden');
        }
    }
    public function deshabilitar_empleado($id) 
    {
        if(Auth()->user()->rol->rol == "ADMIN") 
        {
            $user_name = User::find($id)['name'];
            User::where('id',$id)->update(['habilitado'=>0]);
    
            return redirect()->back()->with('success', 'Empleado ' . $user_name . ' deshabilitado con éxito');  
        }
        else 
        {
            return view('Forbbiden');
        }

    }
    public function habilitar_empleado($id) 
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $user_name = User::find($id)['name'];
            User::where('id',$id)->update(['habilitado'=>1]);
    
            return redirect()->back()->with('success-deshabilitado', 'Empleado ' . $user_name . ' habilitado con éxito');  
        }
        else 
        {
            return view('Forbbiden');
        }
    }

    public function empleado_asignar_tickets(Request $request) 
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $empleado_id = $request->get('empleado_id');
            $request = $request->except('_token', 'empleado_id'); // Aquí están los id de los tickets que se quieren asignar al empleado
            $data = [];
            $ticket_ids = [];

            foreach($request as $ticket_id) {
                array_push($ticket_ids, $ticket_id);
                array_push($data, [
                    'ticket_id' => $ticket_id,
                    'empleado_id' => $empleado_id,
                ]);
            }
            DB::table('ticket_empleado')->insert($data);

            // I need all clients emails
            $ticket_emails = Ticket::select('email')
                ->join('users', 'users.id', 'tickets.cliente_id')
                ->whereIn('tickets.id', $ticket_ids)
                ->get();
            $ticket_titulos = Ticket::select('titulo')
                ->join('users', 'users.id', 'tickets.cliente_id')
                ->whereIn('tickets.id', $ticket_ids)
                ->get();
            $clienteNames_ticketNames = Ticket::select('users.name', 'tickets.titulo')
                ->join('users', 'users.id', 'tickets.cliente_id')
                ->whereIn('tickets.id', $ticket_ids)
                ->get();

            $empleado = User::where('id', $empleado_id)->first();
            $empleado_name = $empleado->name;
            $empleado_mail = $empleado->email;
            
            // Enviar mail to clients
            $data = [];
            for($i=0; $i<count($ticket_emails); $i++){   
                $data = [
                    'ticket_titulo' => $ticket_titulos[$i]['titulo'],
                    'empleado_name' => $empleado_name,                    
                ];
                try {
                    Mail::to($ticket_emails[$i])->send(new tuTicketFueAsignadoA($data));
                }
                catch (Exception $e){} 
            }

            // Enviar mail to empleado
            $data = [];
            $data = [
                'clienteNames_ticketNames' => $clienteNames_ticketNames,
            ];
            Mail::to($empleado_mail)->send(new teFueronAsignadosTickets($data));
            return redirect()->back()->with('success', 'Tickets Asignados');  

        }
        else
        {
            return view('Forbbiden');
        }
    }


    /* Vista de Clientes */
    public function clientes()
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $clientes = User::select(['id', 'name', 'email', 'rfc'])
                ->join('tipos', 'tipos.user_id', '=', 'users.id')
                ->where('tipos.rol', 'CLIENTE')
                ->where('users.habilitado', 1)
                ->paginate(15);

            return view("clientes", [
                'clientes' => $clientes
            ]);  
        }
        else 
        {
            return view('Forbbiden');
        }
    }


    public function showCliente($id)
    {
        if(Auth()->user()->rol->rol == "ADMIN")
        {
            $cliente = User::find($id);
            return view('showCliente', [
                'cliente' => $cliente
            ]);

        }
        else 
        {
            return view('Forbbiden');
        }
    }

    public function agregar_empleado_vista() {
        if(Auth()->user()->rol->rol == "ADMIN") {
            return view('agregar_empleado');
        }
    }

    public function agregar_empleado(Request $request) 
    {
        if(Auth()->user()->rol->rol == "ADMIN") {
            $data = $request->all(); // Corrected method name
            $new_emp = new User();
            $new_emp->name = $data['name']; // Access array elements using []
            $new_emp->email = $data['email']; // Corrected attribute name
            $new_emp->rfc = $data['rfc'];
            $new_emp->habilitado = 1;
            $new_emp->password = Hash::make($data['password']); // Corrected attribute name
            $new_emp->email_verified_at = Carbon::now();
            $new_emp->save(); // Save the user
        
            // Get the ID of the newly created user
            $emp_id = $new_emp->id;
        
            DB::table('tipos')->insert([
                'user_id' => $emp_id,
                'rol' => 'EMPLEADO'
            ]);
        
            return redirect()->back()->with('success', 'Empleado creado con éxito'); 
        }
        else {
            return view('forbidden');
        }
    }
}
