<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    /* Reset styles */
    body, table, th, td {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ddd;
        padding: 10px;
    }
    th {
        background-color: #f2f2f2;
    }
    /* Table styles */
    table {
        width: 100%;
    }
    th, td {
        text-align: left;
    }
    /* Header styles */
    h2 {
        color: #333;
    }
</style>
</head>
<body>
  <div class="message-container">
    Te fueron asignados estos tickets: <br>

    <h2>Ticket Information</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Ticket Title</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['clienteNames_ticketNames'] as $ticket)
              <tr>
                  <td>{{ $ticket->name }}</td>
                  <td>{{ $ticket->titulo }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>


  </div>
</body>
</html>