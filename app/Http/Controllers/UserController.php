<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\ClienteTicket;
use Illuminate\Support\Facades\DB;

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
            $tickets = Ticket::where('estado', "PENDIENTE")->get();
        
    
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
            $ticket_id_cambiar_a_en_atención = [];

            foreach($request as $tikcet_id) {
                array_push($ticket_id_cambiar_a_en_atención, $tikcet_id);
            }

            DB::table('ticket_user')->whereIn('ticket_id', $ticket_id_cambiar_a_en_atención)->update([
                'empleado_id' => $empleado_id
            ]);
            DB::table('tickets')->whereIn('id', $ticket_id_cambiar_a_en_atención)->update([
                'estado' => 'EN REVISION'
            ]);


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
}
