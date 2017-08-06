<html>
  <head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js"></script>

  <script text="text/javascript" src="{{ URL::asset('js/serviceworker/register.js') }}"></script>
  <title>Orders</title>
  </head>

  <body>
    <h4>Orders</h4>

    <table id="app">
      <th>Item</th>
      <th>Quantity</th>
      <th>Address</th>
      <th>Driver ID</th>
        <tr v-for="order in orders">
          <td> @{{ order.item }} </td>

          <td> @{{ order.quantity }} </td>

          <td> @{{ order.address }} </td>

          <td> @{{ order.driver_id }} </td>

          <td>
            <button type="button" @click="completeOrder">Complete</button>
          </td>
        </tr>
      </table>
  </body>

  <script>
    var app = new Vue({
      el: '#app',
      data: {
        orders: [
          {
            item: 'cat',
            quantity: 4,
            address: '4834 Windy St.',
            driver_id: 17
          },
          {
            item: 'Bike',
            quantity: 1,
            address: '1244 Lone Rd.',
            driver_id: 17
          }
        ]
      },
      methods: {
        completeOrder: function () { console.log("completeOrder"); }
      }
    });
  </script>
</html>
