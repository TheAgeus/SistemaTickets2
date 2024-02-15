<x-app-layout>
    
    <link rel="stylesheet" href="{{asset("/css/dashboard/grid-table.css")}}">

    <div class="grid-table clientes-table">
        <div class="header-cell">Nombre</div>
        <div class="header-cell">RFC</div>
        <div class="header-cell">Número de Tickets</div>
        
        @foreach($clientes as $cliente)
            <div class="table-cell">
                {{$cliente->name}}
            </div>
            <div class="table-cell">
                {{$cliente->rfc}}
            </div>
            <div class="table-cell">
                 
            </div>
        @endforeach
    </div>

</x-app-layout>