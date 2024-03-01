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
        .link {
            color: blue;
        }
        .assing_employees_button_open_modal {
            background-color: rgb(0, 0, 193);
            color: white;
            width: fit-content;
            padding: 0.5rem;
            font-weight: bold;
        }
        .assing_employees_button_open_modal:hover{
            cursor: pointer;
        }
        .assing_employees {
            display: flex;
            flex-direction: column;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h2>{{ $ticketData['titulo'] }}</h2>
        </div>
        <div class="card-body">
            <div class="field_two_columns">
                <p><strong>Descripción:</strong></p> 
                <p>{{ $ticketData['descripcion'] }}</p>
            </div>

            <div class="field_one_column">
                <p><strong>Prioridad:</strong> {{ $ticketData['prioridad'] }}</p>
            </div>

            <div class="field_one_column">
                <p><strong>Estatus:</strong> {{ $ticketData['estado'] }}</p>
            </div>

            <div class="field_two_columns">
                <p><strong>Tiempo de Registro:</strong> </p> 
                <p>{{ $ticketData['tiempo_registro'] }}</p>
            </div>

            <div class="field_two_columns">
                <p><strong>Tiempo de Inicio:</strong> </p> 
                <p>{{ $ticketData['tiempo_inicio'] }}</p>
            </div>

            <div class="field_two_columns">
                <p><strong>Tiempo al Finalizar:</strong> </p> 
                <p>{{ $ticketData['tiempo_final'] }}</p>
            </div>

            <div class="field_one_column">
                <p><strong>Cómo fue el servicio:</strong> {{ $ticketData['como_fue_servicio'] }}</p>
            </div>

            <div class="field_two_columns">
                <p><strong>Observaciones:</strong> </p>
                <p>{{ $ticketData['observaciones'] }}</p>
            </div>

            <p><strong>Cliente que pidio el ticket:</strong>  
                <div class="assing_employees">
                    <a class="link" href='/empleados/show/{{ $id_cliente }}'>
                        {{ $nombre_cliente }}
                    </a>
                </div>
            </p>
            <p><strong>Empleados asignados:</strong> 
                <div class="assing_employees">
                    @foreach($empleados_asignados as $empleado)
                        <a class="link" href='/empleados/show/{{ $empleado->id }}'>
                            {{ $empleado->name }}
                        </a>
                    @endforeach

                </div>
            @if(Auth()->user()->rol->rol == "EMPLEADO")  
                @if($ticketData['estado'] == "PENDIENTE")
                    <a class="ticket_action_btn" href="/tickets/{{$ticketData['id']}}/iniciar">Iniciar Ticket</a>
                @elseif($ticketData['estado'] == "EN PROCESO")
                    <a class="ticket_action_btn" href="/tickets/{{$ticketData['id']}}/terminar">Terminar Ticket</a>
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
            @else
                @if($ticketData['estado'] != "CALIFICADO")
                    <div class="assing_employees_button_open_modal">
                        Asignar empleados
                    </div>
                @endif
            @endif

            
            
            <!-- MODAL START -->

            <style>
                .modal{
                    position: fixed;
                    height: calc(100vh - 2rem);
                    background-color: white;
                    width: calc(100vw - 2rem);
                    box-shadow: 1px 1px 5px 1px;
                    top: 0;
                    overflow-y: auto;
                    bottom: 0;
                    
                    padding: 1rem;
                    border-radius: 20px;
                }
                @media (width < 400px){
                    .modal {
                        margin: 0;
                        padding: 1rem;
                        width: 100%;
                    }
                }
                .show {
                    display: hidden;
                }
                .my-hidden {
                    display: none;
                }
                .close-button {
                    width: 2rem;
                    border-radius: 100%;
                    box-shadow: 1px 1px 5px 1px;
                    padding: 10px;
                    position: absolute;
                    right: 1rem;
                    top: 1rem;
                }
                .close-button:hover {
                    cursor: pointer;
                }

                .ticketsTableRows {
                    display: grid;
                    grid-template-columns: 0.5fr 0.5fr 3fr 1fr 0.5fr;
                    gap:  0.5rem;
                    overflow-y: scroll;
                    justify-items: start;
                    align-items: center;
                }
                .title {
                    font-weight: bold;
                    font-size: 1.8rem;
                    margin-block: 1rem;
                }
                .asignar-tickets-button {
                    width: fit-content;
                    background-color: blue;
                    color: white;
                    font-weight: bold;
                    margin-top: 1rem;
                    padding: 0.5rem;
                }

            </style>

            <div class="modal my-hidden">
                <form action="{{route("ticket/asignar/empleados")}}" method="POST">
                    @csrf
                    
                    <input class="ticketId" name="ticket_id" type="hidden" value="">

                    <div class="close-button">
                        <img src="{{asset("/icons/x.png")}}" alt="">
                    </div>
                    <div class="title">
                        Asignar empleados a: 
                    </div>
                    <div class="ticketsTableRows">
                        <div class="header">Add</div>
                        <div class="header">ID</div>
                        <div class="header">Nombre</div>
                        <div class="header">RFC</div>
                        <div class="header">No. Tickets</div>
        
                        @foreach($empleados as $emp)
                            <div class="input">
                                <input name="{{"check" . $emp->empleado_id}}" class="checkbox-input-asignar" type="checkbox" value="{{$emp->empleado_id}}" />
                            </div>
                            <div class="data">
                                {{$emp->empleado_id}} 
                            </div>
                            <div class="data">
                                {{$emp->name}} 
                            </div>
                            <div class="data">
                                {{$emp->rfc}} 
                            </div>
                            <div class="data">
                                {{$emp->num_tickets_assigned}} 
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="submit" class="asignar-tickets-button">Asignar</div>
                </form>
            </div>

            <script>
                const asignarEmpleadosOpenModal = document.querySelector(".assing_employees_button_open_modal");
                const modalElement = document.querySelector(".modal");
                const ticket_id = document.querySelector(".title")
                asignarEmpleadosOpenModal.addEventListener("click", (e) => {
                    document.querySelector(".ticketId").value = {{$ticketData['id']}} 
                    ticket_id.innerHTML = "TABLA DE EMPLEADOS"
                    modalElement.classList.add("show");
                    modalElement.classList.remove("my-hidden");
                })
                const closeBtn = modalElement.querySelector(".close-button") 
            
                closeBtn.addEventListener("click", (e) => {
                if(modalElement.classList.contains("show")) {
                    modalElement.classList.add("my-hidden")
                    modalElement.classList.remove("show")
                }
                else if(modalElement.classList.contains("my-hidden")) {
                    modalElement.classList.add("show")
                    modalElement.classList.remove("my-hidden")
                }
            })
            </script>

        <!-- MODAL END -->

            

        </div>



    </div>
    @if (\Session::has('success'))
        <style>
            .success {
                color: #155724; /* Dark green color */
                background-color: #d4edda; /* Light green background color */
                border: 1px solid #c3e6cb; /* Border color */
                padding: 0.5em 1em; /* Padding */
                border-radius: 0.25em; /* Rounded corners */
                display: inline-block; /* Display as inline-block */
                margin-inline: 1rem;
            }
            .success:hover {
                cursor: pointer;
            }
        </style>  
        <div class="success">
            {!! \Session::get('success') !!} 
        </div>  
        <script>
            const successLabel = document.querySelector(".success");
            successLabel.addEventListener("click", (e) => {
                successLabel.remove();
            });
        </script>
    @endif
          

        


        

</x-app-layout>