<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>


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
                margin: 1rem;
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
                grid-template-columns: 0.5fr 0.3fr 0.5fr 2fr 5fr 1.5fr;
                overflow-y: scroll;
                justify-items: start;
                align-items: center;
            }
            .ticketsTableRows > div {
                border: 1px solid black;
                width: 100%;
                height: 100%;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .title {
                font-weight: bold;
                font-size: 1.8rem;
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
            <form action="{{route("empleados/asignar/ticket")}}" method="POST">
                @csrf

                <input class="empleadoId" name="empleado_id" type="hidden" value="">

                <div class="close-button">
                    <img src="{{asset("/icons/x.png")}}" alt="">
                </div>
                <div class="title">
                    Asignar ticket a: 
                </div>
                <div class="ticketsTableRows">
                    <div class="header">Add</div>
                    <div class="header">No.</div>
                    <div class="header">Prioridad</div>
                    <div class="header">Título</div>
                    <div class="header">Descripcion</div>
                    <div class="header">Empleados Asignados</div>
    
                    @foreach($tickets as $ticket)
                        
                        <div class="input">
                            <input id="{{"check" . $ticket->id}}" name="{{"check" . $ticket->id}}" class="checkbox-input-asignar" type="checkbox" value="{{$ticket->id}}" />
                        </div>
                        <div class="data">
                            {{$ticket->id}} 
                        </div>
                        <div class="data">
                            {{$ticket->prioridad}} 
                        </div>
                        <div class="data">
                            {{$ticket->titulo}} 
                        </div>
                        <div class="data">
                            {{$ticket->descripcion}} 
                        </div>
                        <div class="data">
                            <div class="empleados_asignados" id="emp_asig{{$ticket->id}}">
                                {{$ticket->empleados_asignados}} 
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <button type="submit" class="asignar-tickets-button">Asignar</div>
            </form>
        </div>

        <script>
            const modalElement = document.querySelector(".modal")
            const modalTitleElement = modalElement.querySelector(".title")
            const closeBtn = modalElement.querySelector(".close-button") 
            const allCheckBoxes = document.querySelectorAll('.checkbox-input-asignar')

            function modal(id, name) {

                all_empleados_asignados = document.querySelectorAll('.empleados_asignados');
                all_empleados_asignados.forEach(empleados_asignados => {
                    id_empleado = id;
                    console.log(id_empleado)
                    ids_empleados = empleados_asignados.innerHTML.trim();
                    ids_empleados = ids_empleados.split(',');
                    console.log(ids_empleados);
                    if (ids_empleados.includes(id_empleado.toString())) {
                        check_id = "check" + empleados_asignados.id.replace('emp_asig', '');
                        document.getElementById(`${check_id}`).disabled = true;
                    }
                    else {
                        check_id = "check" + empleados_asignados.id.replace('emp_asig', '');
                        document.getElementById(`${check_id}`).disabled = false;
                    }
                });

                modalTitleElement.innerHTML = "Asigna tickect a: " + name
                document.querySelector(".empleadoId").value = id
                if(modalElement.classList.contains("my-hidden")) {
                    modalElement.classList.add("show")
                    modalElement.classList.remove("my-hidden")
                }
            }

            closeBtn.addEventListener("click", (e) => {

                allCheckBoxes.forEach(element => {
                    element.checked = false;
                });

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

    <x-empleados :empleados="$empleados" :empleadod="$empleadosDeshabilitados" :tickets="$tickets" />

</x-app-layout>