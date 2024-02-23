<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{Auth()->user()->name}}
            {{Auth()->user()->rol->rol}}
        </h2>
    </x-slot>

    <style>
        .content {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .info-card {
            margin-top: 5%;
            padding-block: 1rem;
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            width: 90%;
        }
        .card_row {
            display: flex;
            gap: 0.2rem;
        }
        .label {
            font-weight: bold;
        }
        .icon {
            width: 2rem;
        }
        @media (width < 400px) {
            .card_row {
                flex-direction: column;
                
            }
            .info-card {
                width: 99%;
                align-items: start;
                padding-inline: 1rem;
            }
        }
    </style>

    <div class="content">
        <div class="info-card">
            <div class="icon">
                <img src="{{asset("/icons/hombre-y-mujer.png")}}" alt="">
            </div>
    
            <div class="card_row">
                <div class="label">Id del usuario del {{$cliente->rol->rol}}:</div>
                <div class="id">{{$cliente->id}}</div>
            </div>
            <div class="card_row">
                <div class="label">Nombre: </div>
                <div class="name">{{$cliente->name}}</div>
            </div>
            <div class="card_row">
                <div class="label">Email: </div>
                <div class="emal">{{$cliente->email}}</div>
            </div>
            <div class="card_row">
                <div class="label">RFC: </div>
                <div class="rfc">{{$cliente->rfc}}</div>
            </div>
            <div class="card_row">
                <div class="label">Número de tickets: </div>
                <div class="rfc">{{$cliente->tickets($cliente->rol->rol, $cliente->id)}}</div>
            </div>
        </div>
    </div>


</x-app-layout>