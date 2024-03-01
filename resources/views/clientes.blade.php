<x-app-layout>
    
    <link rel="stylesheet" href="{{asset("/css/dashboard/grid-table.css")}}">

    <style>
        .title {
            padding-inline: 5%;
            font-size: 2rem;
            font-weight: bold;
            margin-top: 5%;
            margin: 1rem;
        }
    </style>

    <div class="title">
        TABLA DE CLIENTES
    </div>

    <div class="grid-table clientes-table">
        <div class="header-cell">Nombre</div>
        <div class="header-cell">RFC</div>
        <div class="header-cell">Número de Tickets</div>
        
        @foreach($clientes as $cliente)
            <div class="table-cell">
                <a class="ticket_link" href='clientes/show/{{ $cliente->id }}'>
                    {{$cliente->name}}
                </a>
            </div>
            <div class="table-cell">
                {{$cliente->rfc}}
            </div>
            <div class="table-cell">
                {{$cliente->tickets("CLIENTE", $cliente->id)}}
            </div>
        @endforeach
    </div>

</x-app-layout>