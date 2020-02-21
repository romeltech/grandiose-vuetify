<template>
  <div class="text-center">
  
      <v-menu
        v-model="menu"
        :close-on-content-click="false"
        :nudge-width="150"
        transition="slide-y-transition"
        offset-y
        :nudge-bottom="3"
      >
        <template v-slot:activator="{ on }">
          <v-btn text icon v-on="on">
            <v-avatar size="36">
              <img src="https://mel-7.com/wp-content/uploads/2019/04/romel-indemne-v1.jpg" alt="Romel Indemne">
            </v-avatar>
          </v-btn>
        </template>

        <v-card>
          <v-list>
            <v-list-item>
              <v-list-item-avatar>
                <img src="https://mel-7.com/wp-content/uploads/2019/04/romel-indemne-v1.jpg" alt="Romel Indemne">
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title> {{ authUser.name }} </v-list-item-title>
                <v-list-item-subtitle>{{ authUser.email }}</v-list-item-subtitle> 
              </v-list-item-content>

            </v-list-item>
          </v-list>
          <v-divider></v-divider>

          <template v-if="authUser.role == 5 ">
            <v-list dense>
              <v-list-item-group color="primary">
                <a v-bind:href="'/u/orders'">
                  <v-list-item><v-list-item-title>Orders</v-list-item-title></v-list-item>
                </a>
                <a v-bind:href="'/u/profile'">
                  <v-list-item><v-list-item-title>Profile</v-list-item-title></v-list-item>
                </a>
                <a v-bind:href="'/u/payment-methods'">
                  <v-list-item><v-list-item-title>Payment Methods</v-list-item-title></v-list-item>
                </a>
                <a v-bind:href="'/u/settings'">
                  <v-list-item><v-list-item-title>Account Settings</v-list-item-title></v-list-item>
                </a>
                <!-- <v-list-item>
                  <v-list-item-title v-on:click="logout">Logout</v-list-item-title>
                </v-list-item> -->
              </v-list-item-group>
            </v-list>
            <v-divider></v-divider>
          </template>

          <v-card-actions>
            <v-btn depressed v-on:click="logout" width="100%">Logout</v-btn>
          </v-card-actions>
      
        </v-card>
      </v-menu>
  </div>
</template>

<script>
  export default {
    props: ['authUser'],
    data: () => ({
      fav: true,
      menu: false,
      message: false,
      hints: true,
    }),
    methods: {
      logout: function (event) {
        event.preventDefault();
        document.getElementById('logout-form').submit();
      },
      // url: function() {
      //   window.location.href = '/account/';
      // }
    }
  }
</script>