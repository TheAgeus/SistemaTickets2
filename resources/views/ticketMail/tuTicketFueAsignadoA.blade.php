<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <style>
    .message {
        padding: 10px 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .message strong {
        font-weight: bold;
        color: #333;
    }
  </style>

</head>
<body>
  
  <div class="message">
    Tu ticket: <strong>{{$data['ticket_titulo']}}</strong> ha sido asignado al empleado: <strong>{{$data['empleado_name']}}</strong>
  </div>

</body>
</html>