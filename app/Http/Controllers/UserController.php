<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;

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
}
