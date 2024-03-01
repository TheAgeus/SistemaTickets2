<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>

    <style>
        .instructions-div {
            width: 90%;
            margin: 5rem auto;
            font-size: 1.5rem;
            display: flex;
            gap: 1rem;
            flex-direction: column;
        }
    </style>

    <div class="instructions-div">
        @if(Auth()->user()->rol->rol == "ADMIN")
            <div class="instruction">
                <p>
                    - En la pestaña "Empleados" se pueden ver todos los empleados, se puede asignar un ticket o varios tickets a un empleado..
                </p>
            </div>
            <div class="instruction">
                <p>
                    - En la pestaña de "Tickets" se pueden ver todos los tickets, aquí puedes entrar a la vista del ticket y asignar un empleado o varios a un ticket.
                </p>
            </div>
        @elseif(Auth()->user()->rol->rol == "EMPLEADO")
            <div class="instruction">
                <p>
                    - En la pestaña "Mis tickets" puedes ver que tickets tienes asignados. Para iniciarlos deberás entrar a la vista del ticket dando click en el título del ticket.
                </p>
            </div>
            <div class="instruction">
                <p>
                    - Ya estando en la vista del ticket, puedes iniciar el ticket. Además de terminarlo.
                </p>
            </div>
        @elseif(Auth()->user()->rol->rol == "CLIENTE")
            <div class="instruction">
                <p>
                    - En la pestaña "Mis tickets" puedes ver que tickets tienes asignados. Para iniciarlos deberás entrar a la vista del ticket dando click en el título del ticket.
                </p>
            </div>
            <div class="instruction">
                <p>
                    - También puedes agregar un ticket desde la pestaña de "Agregar Ticket"
                </p>
            </div>
        @endif
    </div>
    

</x-app-layout>
