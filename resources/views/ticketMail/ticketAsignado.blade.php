<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <style type="text/css">
    /*
    .ticket-container {
      width: 90%;
      margin: auto;
      margin-top: 2rem;
      box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }
    .title{
      font-size: 2rem;
      font-weight: bold; 
      text-align: center;
      width: 100%; 
      margin-bottom: 2rem;
    }
    .field {
      width: 100%;
      margin-bottom: 2rem;
    }
    .field > .text {
      font-size: 1.2rem;
      font-weight: bold;
    }
    */
    body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
  }

  /* Estilos del contenedor del ticket */
  .ticket-container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
  }

  /* Estilos del título */
  .title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  /* Estilos de los campos */
  .field {
    margin-bottom: 15px;
  }

  /* Estilos de la etiqueta */
  .label {
    font-weight: bold;
    margin-bottom: 5px;
  }

  /* Estilos del texto */
  .text {
    font-size: 16px;
  }
  </style>

</head>
<body>
  <div class="ticket-container">
    <div class="title">
      Ticket Asignado!!!
    </div>
  
    <div class="field">
      <div class="label">CLIENTE QUE SOLICITA</div>
      <div class="text">{{$data['cliente_name']}}</div>
    </div>

    <div class="field">
      <div class="label">EMPLEADOS ASIGNADOS</div>
        @foreach($data['empleados_names'] as $empleado_name)
          <div class="text">{{$empleado_name}}</div>
        @endforeach
    </div>

    <div class="field">
      <div class="label">TICKET ID</div>
      <div class="text">{{$data['ticket_id']}}</div>
    </div>
  
    <div class="field">
      <div class="label">TÍTULO DEL TICKET</div>
      <div class="text">{{$data['ticket_title']}}</div>
    </div>
  
    <div class="field">
      <div class="label">DESCRIPCIÓN DEL TICKET</div>
      <div class="text">{{$data['ticket_descripcion']}}</div>
    </div>
  
    <div class="field">
      <div class="label">PRIORIDAD DEL TICKET</div>
      <div class="text">{{$data['ticket_prioridad']}}</div>
    </div>
  
    <div class="field">
      <div class="label">TIEMPO DE REGISTRO</div>
      <div class="text">{{$data['ticket_tiempo_registro']}}</div>
    </div>


  
  </div>
</body>
</html>


