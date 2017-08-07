<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.4.2/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>

    <script text="text/javascript" src="{{ URL::asset('js/serviceworker/register.js') }}"></script>
    <title>Orders</title>
  </head>

  <body>

    <div class="container" id="app">

      <div class="text-center">
        <h3>All Orders</h3>
      </div>

      <ul class="list-group">

        <li class="list-group-item list-group-item-info">
          <div class="row text-center">
            <div class="col-lg-4"><strong>Item</strong></div>
            <div class="col-lg-1"><strong>Quantity</strong></div>
            <div class="col-lg-4"><strong>Address</strong></div>
            <div class="col-lg-1"><strong>Driver ID</strong></div>
          </div>
        </li>

        <li class="list-group-item" v-for="order in orders">
          <order :order.sync="order"></order>
        </li>

      </ul>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="saveOrders">Save</button>
      </div>

      @{{ $data }}
    </div>

  </body>

  <template id="order-template">
    <div class="row text-center">
      <div class="col-lg-4"> @{{ order.item }}</div>
      <div class="col-lg-1"> @{{ order.quantity }}</div>
      <div class="col-lg-4"> @{{ order.address }}</div>
      <div class="col-lg-1"> @{{ order.driver_id }}</div>
      <div class="col-lg-1">
        <button type="button" class="btn btn-default btn-xs" @click="toggleOrderCompleted(order)">@{{ isCompleted ? 'Completed' : 'Uncompleted'  }}</button>
      </div>
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
        },
        saveOrders: function()  {
          console.log("saveOrders")
        }
      },

      components: {
        order: {
          template: '#order-template',
          props: ['order'],

          methods: {
            toggleOrderCompleted: function (order) { order.completed = !order.completed }
          },

          computed: {
            isCompleted: function() { return this.order.completed }
          }
        }
      }
    });
  </script>
</html>
