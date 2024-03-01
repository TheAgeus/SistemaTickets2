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
    
  @if($data['cambio_estado'] == "INICIADO")
    <h1>Se ha iniciado tu ticket</h1> 
  @elseif($data['cambio_estado'] == "TERMINADO")
    <h1>Se ha terminado tu ticket</h1> 
  @endif 
    <div class="ticket-info">
        <label>Título del ticket:</label>
        <div>{{$data['ticket_title']}}</div>
    </div>
    <div class="ticket-info">
        @if($data['cambio_estado'] == "INICIADO")
          <label>Nombre del empleado quien lo inició:</label>
        @elseif($data['cambio_estado'] == "TERMINADO")
          <label>Nombre del empleado quien lo terminó:</label> 
        @endif 
        
        <div>{{$data['nombre_empleado']}}</div>
    </div>
</div>
</body>
</html>