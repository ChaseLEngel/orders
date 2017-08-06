<html>
  <head>
  <script text="text/javascript" src="{{ URL::asset('js/serviceworker/register.js') }}"></script>
  <title>Orders</title>
  </head>

  <body>
    <h4>Orders</h4>

    <table>
      <th>Item</th>
      <th>Quantity</th>
      <th>Address</th>
      <th>Driver ID</th>

      @foreach ($orders as $order)
        <tr>
          <td>
            {{ $order->item }}
          </td>

          <td>
            {{ $order->quantity }}
          </td>

          <td>
            {{ $order->address }}
          </td>

          <td>
            {{ $order->driver_id }}
          </td>
        </tr>
      @endforeach
    </table>

  </body>
</html>
