<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>

    <x-empleados :empleados="$empleados" :empleadod="$empleadosDeshabilitados" />

</x-app-layout>