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
                grid-template-columns: 0.5fr 0.3fr 0.5fr 2fr 5fr;
                gap:  0.5rem;
                overflow-y: scroll;
                justify-items: start;
                align-items: center;
            }
            .title {
                font-weight: bold;
                font-size: 1.8rem;
            }

        </style>

        <div class="modal my-hidden">
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

                @foreach($tickets as $ticket)
                    <div class="input">
                        <input type="checkbox" id="cbox1" value="{{$ticket->id}}" />
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
                @endforeach
            </div>
            
            <div class="asignar-tickets-button"></div>
        </div>

        <script>
            const modalElement = document.querySelector(".modal")
            const modalTitleElement = modalElement.querySelector(".title")
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

    <x-empleados :empleados="$empleados" :empleadod="$empleadosDeshabilitados" :tickets="$tickets" />

</x-app-layout>