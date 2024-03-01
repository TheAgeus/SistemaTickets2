<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticket Iniciado</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
    h1 {
        color: #333;
        margin-bottom: 20px;
    }
    .ticket-info {
        margin-bottom: 20px;
    }
    .ticket-info label {
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
    

    <h1>Se ha calificado un ticket</h1> 

    <div class="ticket-info">
        <label>Título del ticket:</label>
        <div>{{$data['ticket_title']}}</div>
    </div>
    <div class="ticket-info">
        <label>Nombre del los empleados:</label>
        @foreach ($data['nombres_empleados'] as $item)
          <div>{{$item}}</div>
        @endforeach
    </div>

    <div class="ticket-info">
      <label>Como fue el servicio:</label>
      <div>{{$data['como_fue_servicio']}}</div>
    </div>

  <div class="ticket-info">
    <label>Observaciones:</label>
    <div>{{$data['observaciones']}}</div>
  </div>

</div>
</body>
</html>