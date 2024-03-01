<x-app-layout>

    <style>
        .myform {
            width: fit-content;
            margin: auto;
            margin-top: 5rem;
            padding: 1rem;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }
        #prioridad {
            width: 100%;
        }
        textarea {
            width: 100%;
        }
        button {
            color: #fff;
            background-color: black !important; 
            padding: 0.5rem 1rem;
            margin-top: 5px;
        }
        input{
            width: 100%;
        }
        .form-title {
            font-weight: bold;
            text-align: center;
            width: 100%;
        }
        @media (width < 400px) {
            form {
                width: 92%;
            }
        }
        .error-message {
            background-color: #edd4d4; /* Light red background */
            color: #9a2929; /* Dark red text color */
            padding: 10px;
            border: 1px solid #e6c3c3; /* Light red border */
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .msg-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
    </style>

    <div class="form-container">

        

        <form class="myform" action="{{route("tickets/add/post")}}" method="POST">
            @csrf

            <div class="form-title">
                AGREGAR TICKET
            </div>

            <input type="hidden" value="{{Auth()->user()->id}}" name="user_id">

            <div class="input-group">
                <div class="label">Título: </div>
                <input type="text" name="titulo">
            </div>

            <div class="input-group">
                <div class="label">Descripcion: </div>
                <textarea name="descripcion" id="descripcion"></textarea>
            </div>

            <div class="input-group">
                <div class="label">Prioridad: </div>
                <select name="prioridad" id="prioridad">
                    <option value="Alta">Alta</option>
                    <option value="Medio alta">Medio alta</option>
                    <option value="Media">Media</option>
                    <option value="Medio baja">Medio baja</option>
                    <option value="Baja">Baja</option>
                </select>
            </div>

            <button type="submit">Enviar</button>

            @if (\Session::has('success'))
                <div class="msg-success">
                    {!! \Session::get('success') !!} 
                </div>
            @endif
            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger text-center error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="color: rgb(220, 1, 1);">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

</x-app-layout>