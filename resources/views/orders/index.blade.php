<html>
  <head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js"></script>

  <script text="text/javascript" src="{{ URL::asset('js/serviceworker/register.js') }}"></script>
  <title>Orders</title>
  </head>

  <body>
    <div id="app">
      <div v-for="order in orders">
        <order :order="order"></order>
      </div>
    </div>
  </body>

  <template id="order-template">
    <div>
      <span> @{{ order.item }} </span>
      <span> @{{ order.quantity }} </span>
      <span> @{{ order.address }} </span>
      <span> @{{ order.driver_id }} </span>
    </div>
  </template>

  <script>

    var orders = [
      {
        item: 'Hat',
        quantity: 10,
        address: '1234 Lake St.',
        driver_id: 13
      },
      {
        item: 'Shoe',
        quantity: 8,
        address: '4835 Blake Rd.',
        driver_id: 4
      },
      {
        item: 'Shirt',
        quantity: 2,
        address: '3843 Lane St.',
        driver_id: 3
      }
    ]

    new Vue({
      el: '#app',
      data: function() {
          return { orders: orders }
      },
      components: {
        order: {
          template: "#order-template",
          props: ['order']
        }
      }
    });
  </script>
</html>
