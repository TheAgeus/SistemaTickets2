<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{Auth()->user()->name}}
          {{Auth()->user()->rol->rol}}
      </h2>
  </x-slot>

  <style>
    .downloadTicketsExcelForm{
          border: 1px solid black;
          padding: 1rem;
      }
      .downloadTicketsExcelForm > .input-group {
          display: flex;
          flex-direction: column;
          margin-top: 1rem;
      }
      .downloadTicketsExcelForm > button {
          background-color: blue;
          color: white;
          padding: 0.5rem 1rem; 
          margin-top: 1rem;
      }
      .title-label {
          font-size: 1.2rem;
          font-weight: bold;
      }
      .input-subgroup {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }
  </style>

  <form class="downloadTicketsExcelForm" action="{{route('export')}}" method="POST">
    @csrf
    <div class="input-group">
      <label class="title-label" for="estadoExcel">Seleccionar un estado</label>
      <div class="input-subgroup">
        <input type="checkbox" name="estadoPendiente" id="estadoPendiente">
        <label for="estadoPendiente">PENDIENTE</label>
      </div>

      <div class="input-subgroup">
        <input type="checkbox" name="estadoEnProceso" id="estadoEnProceso">
        <label for="estadoEnProceso">EN PROCESO</label>
      </div>

      <div class="input-subgroup">
        <input type="checkbox" name="estadoTerminado" id="estadoTerminado">
        <label for="estadoTerminado">TERMINADO</label>
      </div>

      <div class="input-subgroup">
        <input type="checkbox" name="estadoCalificado" id="estadoCalificado">
        <label for="estadoCalificado">CALIFICADO</label>
      </div>
    </div>

    <div class="input-group">
        <label class="title-label" for="prioridad">Seleccionar prioridad</label>
        
        <div class="input-subgroup">
          <input type="checkbox" name="prioridadMuyAlta" id="prioridadMuyAlta">
          <label for="prioridadMuyAlta">MUY ALTA</label>
        </div>

        <div class="input-subgroup">
          <input type="checkbox" name="prioridadAlta" id="prioridadAlta">
          <label for="prioridadAlta">ALTA</label>
        </div>

        <div class="input-subgroup">
          <input type="checkbox" name="prioridadMedia" id="prioridadMedia">
          <label for="prioridadMedia">MEDIA</label>
        </div>

        <div class="input-subgroup">
          <input type="checkbox" name="prioridadMediaBaja" id="prioridadMediaBaja">
          <label for="prioridadMediaBaja">MEDIA BAJA</label>
        </div>

        <div class="input-subgroup">
          <input type="checkbox" name="prioridadBaja" id="prioridadBaja">
          <label for="prioridadBaja">BAJA</label>
        </div>
      </div>

    <div class="input-group">
        <label class="title-label" for="titulo">Escribe el título</label>
        <input name="titulo" type="text" placeholder="titulo">
    </div>

    <div class="input-group">
        <label class="title-label" for="fecha_registro">Fecha de registro</label>
        <input name="fecha_registro" type="date">
    </div>

    <div class="input-group">
        <label class="title-label" for="fecha_inicio">Fecha de inicio</label>
        <input name="fecha_inicio" type="date">
    </div>

    <div class="input-group">
        <label class="title-label" for="fecha_final">Fecha de final</label>
        <input name="fecha_final" type="date">
    </div>

    <div class="input-group">
        <label class="title-label" for="anio">Año</label>
        <input name="anio" type="number" min="2024" max="9999">
    </div>

    <div class="input-group">
        <label class="title-label" for="mes">Mes</label>
        <select name="mes">
            <option value=""></option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
    </div>

    <button type="submit">
        Descargar Excel
    </button>

</form>
  
</x-app-layout>