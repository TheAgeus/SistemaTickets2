<x-app-layout>

    <div class="form-container">

        @if (\Session::has('success'))
            <div class="msg-success">
                {!! \Session::get('success') !!} 
            </div>
        @endif

        <form action="{{route("tickets/add/post")}}" method="POST">
            @csrf

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
        </form>
    </div>

</x-app-layout>