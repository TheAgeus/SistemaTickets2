<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>

    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f2f2f2;
            padding: 10px 20px;
            border-bottom: 1px solid #ccc;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-header h2 {
            margin: 0;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            margin: 0 0 10px;
        }

        strong {
            font-weight: bold;
        }
        .ticket_action_btn  {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
            margin: 0rem;
            background-color: rgb(32, 32, 219);
            color: white;
            padding: 0.5rem 1rem;
            font-weight: bold;
        }
        .mybutton {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
            margin: 0rem;
            background-color: rgb(32, 32, 219);
            color: white;
            padding: 0.5rem 1rem;
            font-weight: bold;
            margin-top: 1rem;
        }
        .form_row_column {
            display: flex;
            flex-direction: column;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h2>{{ $ticketData['titulo'] }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $ticketData['descripcion'] }}</p>
            <p><strong>Priority:</strong> {{ $ticketData['prioridad'] }}</p>
            <p><strong>Status:</strong> {{ $ticketData['estado'] }}</p>
            <p><strong>Registered Time:</strong> {{ $ticketData['tiempo_registro'] }}</p>
            <p><strong>Start Time:</strong> {{ $ticketData['tiempo_inicio'] }}</p>
            <p><strong>End Time:</strong> {{ $ticketData['tiempo_final'] }}</p>
            <p><strong>Service Feedback:</strong> {{ $ticketData['como_fue_servicio'] }}</p>
            <p><strong>Observations:</strong> {{ $ticketData['observaciones'] }}</p>
            <p><strong>Client:</strong> {{ $ticketData['cliente_name'] }} (ID: {{ $ticketData['cliente_id'] }})</p>
            <p><strong>Employee:</strong> {{ $ticketData['empleado_name'] }} (ID: {{ $ticketData['empleado_id'] }})</p>
            @if(Auth()->user()->rol->rol == "EMPLEADO")  
                @if($ticketData['estado'] == "PENDIENTE")
                    <a class="ticket_action_btn" href="{{$ticketData['id']}}/iniciar">Iniciar Ticket</a>
                @elseif($ticketData['estado'] == "EN PROCESO")
                    <a class="ticket_action_btn" href="{{$ticketData['id']}}/terminar">Terminar Ticket</a>
                @endif
            @elseif(Auth()->user()->rol->rol == "CLIENTE")
                @if($ticketData['estado'] == "TERMINADO")
                    <form action="{{route('calificarTicket')}}" method="POST">
                        @csrf
                        <div class="form_row">
                            <label for="como_fue_servico">¿Cómo fue el servicio?</label>
                            <select name="como_fue_servicio" id="como_fue_servicio" required>
                                <option value=""></option>
                                <option value="MUY BUENO">MUY BUENO</option>
                                <option value="BUENO">BUENO</option>
                                <option value="REGULAR">REGULAR</option>
                                <option value="MALO">MALO</option>
                                <option value="MUY MALO">MUY MALO</option>
                            </select>
                        </div>
                        <div class="form_row_column">
                            <label for="observaciones">observaciones</label>
                            <textarea name="observaciones" id="observaciones" required></textarea>
                        </div>
                        <input type="hidden" name="ticket_id" value="{{$ticketData['id']}}">
                        <button class="mybutton" type="submit">Calificar Ticket</button>
                    </form>
                @endif
            @endif
        </div>


    </div>

</x-app-layout>