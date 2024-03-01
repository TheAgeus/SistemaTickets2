<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>
    
    <link rel="stylesheet" href="{{asset("/css/dashboard/grid-table.css")}}">

    <div class="grid-table my-tickets-table">
        <div class="header-cell">Titulo</div>
        <div class="header-cell">Descripcion</div>
        <div class="header-cell">Prioridad</div>
        <div class="header-cell">Estado</div>
        <div class="header-cell">Tiempo registro</div>
        

        @foreach($tickets as $ticket)
            <div> 
                <a class="ticket_link" href='/tickets/show/{{ $ticket->id }}'>
                    {{ $ticket->titulo }}
                </a>
            </div>
            <div> {{ $ticket->descripcion }} </div>
            <div> {{ $ticket->prioridad }} </div>
            <div> {{ $ticket->estado }} </div>
            <div> {{ $ticket->tiempo_registro }} </div>
        @endforeach
    </div>

</x-app-layout>