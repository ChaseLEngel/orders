<html>
  <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>

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


    new Vue({
      el: '#app',

      data: function() {
          return { orders: [] }
      },

      created: function() {
        this.fetchOrders();
      },

      methods: {
        fetchOrders: function() {
          this.$http.get('api/orders').then(response => {
            this.orders = response.body;
            }, response => {
              console.error("Failed to get orders from api.")
            });
        }
      },

      components: {
        order: {
          template: '#order-template',
          props: ['order']
          }
        }
    });
  </script>
</html>
