<x-app-layout>

    <link rel="stylesheet" href="{{asset("/css/dashboard/grid-table.css")}}">

    <div class="grid-table tickets-table">
        <div class="header-cell">Id</div>
        <div class="header-cell">Título</div>
        <div class="header-cell">Descripcion</div>
        <div class="header-cell">Prioridad</div>
        <div class="header-cell">Estado</div>
        @foreach($tickets as $ticket)
            <div class="table-cell">
                {{$ticket->id}}
            </div>
            <div class="table-cell">
                {{$ticket->titulo}}
            </div>
            <div class="table-cell">
                {{$ticket->descripcion}}
            </div>
            <div class="table-cell">
                {{$ticket->prioridad}}
            </div>
            <div class="table-cell">
                {{$ticket->estado}}
            </div>
        @endforeach
    </div>


</x-app-layout>