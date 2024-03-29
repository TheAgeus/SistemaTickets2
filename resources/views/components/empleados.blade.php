@if(Auth()->user()->rol->rol == "ADMIN")

    <style>
        .TableTitle {
            font-weight: bold;
            font-size: 1.8rem;
            text-align: left;
            padding: 1rem 5% 1rem 5%;
        }

        .msg-success, .msg-success-deshabilitado {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text color */
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto; /* Center the card horizontally */
            max-width: 400px; /* Limit card width */
        }

        .empleadosTable {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
            
        }
        .ticketsTable {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
        }
        .empleadosTableRows {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding-inline: 5%;
            overflow-y: scroll;
            justify-items: start;
            align-items: start;
        }
        
        .header {
            font-weight: bold;
            border: 1px solid black;
            text-align: left;
            width: 100%;
            height: 100%;
        }
        .data {
            display: flex;
            justify-content: start;
            align-items: center;
            word-wrap:break-word;
            border: 1px solid black;
            width: 100%;
            height: 100%;
        }
        .link {
            color: blue;
        }
        .icon {
            margin: 0.8rem;
            width: 2rem;
        }

        .gapApertura {
            height: 5rem;
        }

        .notas {
            display: flex;
            flex-direction: column;
            padding: 1rem 5% 1rem 5%;
            border-radius: 20px;
        }
        .notas > .nota  {
            display: flex;
            gap: 1rem
        }
        .notas > .nota > img {
            width: 1.5rem;
        }

        @media (width < 400px) {
            .data {
                font-size: 0.8rem;
            }
            .empleadosTableRows {
                padding-inline: 5%;
            }
            .empleadosTableTitle {
                font-size: 1.5rem;
            }
            .header {
                font-size: 1rem;
            }
            
        }

    </style>

    <!-- PARTE DE LA TABLA DE LOS EMPLEADOS HABILITADOS -->
    <!-- INSTRUCCIONES O NOTAS -->
    <div class="notas">
        <div class="nota">
            <div class="nota-texto" style="font-weight: bold;">
                Instrucciones:
            </div>
        </div>
        <div class="nota">
            <div class="nota-texto">Deshabilitar Empleado</div>
            <img src="{{asset("/icons/delete.png")}}" alt="">
        </div>
        <div class="nota">
            <div class="nota-texto">Asignar Ticket</div>
            <img src="{{asset("/icons/letter.png")}}" alt="">
        </div>
    </div>

    <!-- LA TABLA EN SI, LOS HEADERS Y LOS DATOS (CELDAS) -->
    <div class="empleadosTable">
        <div class="TableTitle">
            TABLA DE EMPLEADOS
        </div>

        <!-- MENSAJES -->
        @if (\Session::has('success'))
            <div class="msg-success">
                {!! \Session::get('success') !!} 
            </div>
            <script>
                document.querySelector("msg-success")
            </script>
        @endif

        <!-- LA TABLA EN SI DE VERDAD JAJAJA -->
        <div class="empleadosTableRows">
            <div class="header">NOMBRE</div>
            <div class="header">RFC</div>
            <div class="header">ACCIONES</div>
    
            @foreach($empleados as $empleado)
                <div class="data">
                    <a class="link" href='empleados/show/{{ $empleado->id }}'>
                        {{$empleado->name}}
                    </a>
                </div>
                <div class="data">{{$empleado->rfc}}</div>
                <div class="data">
                    <a class="icon" href="/empleados/deshabilitar/{{$empleado->id}}"><img src="{{asset("/icons/delete.png")}}" alt=""></a>
                    <a class="assign-ticket-btn icon" href="#" onclick="modal(`{{$empleado->id}}`, `{{$empleado->name}}`)" ><img src="{{asset("/icons/letter.png")}}" alt=""></a>
                </div>
            @endforeach 
            
            
            {{ $empleados->links() }}
            
        </div>
    </div>

    <script>
        assignTicketBtns = document.querySelectorAll(".assign-ticket-btn")
        
        assignTicketBtns.forEach(element => {
            element.addEventListener("click", (e) => {
                e.preventDefault()
            })
        });

        
    </script>

    <!-- GAP O ABERTURA PARA QUE LAS TABLAS NO SE VEAN TAN JUNTAS -->
    <div class="gapApertura">
    </div>

    <!-- LA SECCIÓN DE LA TABLA DE LOS EMPLEADOS DESHABILITADOS -->
    <!-- NOTAS O INSTRUCCIONES -->
    <div class="notas">
        <div class="nota">
            <div class="nota-texto" style="font-weight: bold;">
                Instrucciones:
            </div>
        </div>
        <div class="nota">
            <div class="nota-texto">Habilitar Empleado</div>
            <img src="{{asset("/icons/angel.png")}}" alt="">
        </div>
    </div>

    <!-- COMIENZO DE LA TABLA -->
    <div class="empleadosTable">
        <div class="TableTitle">
            TABLA DE EMPLEADOS DESHABILITADOS
        </div>
        
        <!-- MENSAJES -->
        @if (\Session::has('success-deshabilitado'))
            <div class="msg-success-deshabilitado">
                {!! \Session::get('success-deshabilitado') !!} 
            </div>
            <script>
                document.querySelector("msg-success-deshabilitado")
            </script>
        @endif

        <!-- CELDAS DE LA TABLA -->
        <div class="empleadosTableRows">
            <div class="header">NOMBRE</div>
            <div class="header">RFC</div>
            <div class="header">ACCIONES</div>
    
            @foreach($empleadod as $empleado_deshabilitado)
                <div class="data">{{$empleado_deshabilitado->name}}</div>
                <div class="data">{{$empleado_deshabilitado->rfc}}</div>
                <div class="data">
                    <a href="/empleados/habilitar/{{$empleado_deshabilitado->id}}"><img src="{{asset("/icons/angel.png")}}" alt=""></a>
                </div>
            @endforeach 

            {{$empleadod->links()}}
        </div>
    </div>

@endif

