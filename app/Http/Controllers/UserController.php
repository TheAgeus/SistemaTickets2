<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function empleados() 
    {
        $empleados = User::select(['id', 'name', 'email', 'rfc'])
            ->join('tipos', 'tipos.user_id', '=', 'users.id')
            ->where('tipos.rol', 'EMPLEADO')
            ->where('users.habilitado', 1)
            ->paginate(10);
        $empleados_deshabilitados = User::select(['id', 'name', 'email', 'rfc'])
            ->join('tipos', 'tipos.user_id', '=', 'users.id')
            ->where('tipos.rol', 'EMPLEADO')
            ->where('users.habilitado', 0)
            ->paginate(10);

        return view("empleados", [
            'empleados' => $empleados,
            'empleadosDeshabilitados' => $empleados_deshabilitados 
        ]);
    }

    public function deshabilitar_empleado($id) 
    {
        $user_name = User::find($id)['name'];
        User::where('id',$id)->update(['habilitado'=>0]);

        return redirect()->back()->with('success', 'Empleado ' . $user_name . ' deshabilitado con éxito');  
    }

    public function habilitar_empleado($id) 
    {
        $user_name = User::find($id)['name'];
        User::where('id',$id)->update(['habilitado'=>1]);

        return redirect()->back()->with('success-deshabilitado', 'Empleado ' . $user_name . ' habilitado con éxito');  
    }
}
