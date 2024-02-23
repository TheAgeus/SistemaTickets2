<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>
    <style>
        form {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            margin: 1rem;
            padding: 1rem;
        }
        .mybutton {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
            margin: 0.5rem 1rem;
            padding: 0.5rem 1rem;
        }
        select {
            font-size: 0.8rem;
            padding: 0 1rem;
            margin: 0 1rem;
        }
        .table-container {
            overflow-x: auto;
        }

        table {
            width: calc(100% - 2rem);
            border-collapse: collapse;
            margin: 1rem;

        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        .ticket_link {
            color: rgb(60, 60, 255);
        }
        .ticket_link:hover {
            color: rgb(119, 175, 254);
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            th, td {
                padding: 6px;
                font-size: 12px;
            }
        }
    </style>

    <form action="{{route('seleccionar_tickets')}}" method="GET">

        <input type="hidden" name="user_id" value="{{Auth()->user()->id}}">

        <div class="form_row">
            <div class="select_group">
                <label for="estado_tickets">
                    Seleccione el estado de ticket que quiere visualizar:
                </label>
                <select name="estado_tickets" id="estado_tickets">
                    <option value=""></option>
                    <option value="PENDIENTE">PENDIENTE</option>
                    <option value="EN REVISION">EN REVISION</option>
                    <option value="TERMINADO">TERMINADO</option>
                    <option value="CALIFICADO">CALIFICADO</option>
                    <option value="TODOS">TODOS</option>
                </select>
            </div>
        </div>

        <div class="form_row">
            <button class="mybutton" type="submit">Enviar</button>
        </div>
    </form>

    @isset($tickets)
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket['ticket_id'] }}</td>
                        <td>
                            <a class="ticket_link" href='tickets/show/{{ $ticket['ticket_id'] }}'>
                                {{ $ticket['titulo'] }}
                            </a>
                        </td>
                        <td>{{ $ticket['descripcion'] }}</td>
                        <td>{{ $ticket['prioridad'] }}</td>
                        <td>{{ $ticket['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>No tickets found.</p>
    @endisset



</x-app-layout>