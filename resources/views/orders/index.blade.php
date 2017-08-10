<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="text/javascript" src="{{ URL::asset('/js/app.js') }}"></script>

    <link href="{{ URL::asset('css/app.css') }}" type="text/css" rel="stylesheet"></link>

    <script type="text/javascript" src="{{ URL::asset('/register.js') }}"></script>

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

      <div v-show="showSaveAlert" class="alert text-center" :class="{'alert-danger': saveError, 'alert-success': !saveError}">
        @{{saveError ? 'Failed to save orders' : 'Successfully saved orders'}}
      </div>

      <div class="text-center">
        <button type="button" class="btn btn-primary" @click="saveOrders">Save</button>
        <button type="button" class="btn btn-primary" :class="{active: showData}" @click="toggleShowData">Show Data</button>
      </div>

      <div v-show="showData">
        @{{ $data }}
      </div>
    </div>

  </body>

  <template id="order-template">
    <div class="row text-center">
      <div class="col-lg-4"> @{{ order.item }}</div>
      <div class="col-lg-1"> @{{ order.quantity }}</div>
      <div class="col-lg-4"> @{{ order.address }}</div>
      <div class="col-lg-1"> @{{ order.driver_id }}</div>
      <div class="col-lg-1">
        <button type="button" class="btn btn-default btn-xs" :class="{active: isCompleted}" @click="toggleOrderCompleted(order)">@{{ isCompleted ? 'Completed' : 'Uncompleted'  }}</button>
      </div>
    </div>
  </template>

  <script>

    var db = new Dexie("Orders");
    db.version(1).stores({
      orders: "++id,item,quantity,address,driver_id,completed,created_at,updated_at"
    });

    new Vue({
      el: '#app',

      data: function() {
          return {
            orders: [],
            showData: false,
            showSaveAlert: false,
            saveError: false
          }
      },

      created: function() {
        this.fetchOrders();
      },

      methods: {
        // Request array of orders from API endpoint.
        fetchOrders: function() {
          this.$http.get('api/orders').then(function(response) {

            console.log(response);
          
            //console.log(`Fetched ${response.body.length} orders from API.`);

            // Update IndexedDB with new data.
            this.syncWithOrdersStore(response.body);

          }).catch(function(e) {
            console.error("Failed to get orders from api:" + e);
          });
        },

        // Takes array of order objects and updates IndexedDB Orders store with array data.
        syncWithOrdersStore: function(orders) {
          var vm = this;

          db.orders.bulkPut(orders).then(function(lastOrder) {

            console.log("Finished syncing IndexedDB with API.");

            // To keep API-IndexedDB data flow constant read data again from IndexedDB for display.
            vm.getOrders().then(function(orders) {
              vm.orders = orders;
            });

          }).catch(Dexie.BulkError, function(e) {

            console.error(e);

          });
        },

        // Send put request to API with array of orders from IndexedDB.
        saveOrders: function()  {
          var vm = this;

          this.getOrders().then(function(orders) {
            vm.$http.put('api/orders', orders).then(function() {

              vm.saveError = false;

            }).catch(function(e) {

              vm.saveError = true;
              console.error("Failed to save orders.");

            }).finally(function() {

              vm.showSaveAlert = true;

            });
          });
        },

        toggleShowData: function() {
          this.showData = !this.showData;
        },

        // Start a IndexedDB transation and return promise for an array of order objects.
        getOrders: function() {
          return db.transaction("r", db.orders, function() {
            return db.orders.toArray();
          })
        }
      },

      components: {
        order: {
          template: '#order-template',
          props: ['order'],

          methods: {
            toggleOrderCompleted: function (order) {
              order.completed = !order.completed;
              db.orders.put(order);
            }
          },

          computed: {
            isCompleted: function() { return this.order.completed }
          }
        }
      }
    });
  </script>
</html>
