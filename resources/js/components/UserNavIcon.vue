<template>
  <div class="text-center">
    <v-menu
      v-model="menu"
      :close-on-content-click="false"
      :nudge-width="150"
      transition="slide-y-transition"
      offset-y
      :nudge-bottom="10"
    >
      <template v-slot:activator="{ on }">
        <v-btn class="ma-3" text icon v-on="on">
          <v-avatar>
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

        <v-list dense>
          <v-list-item-group color="primary">
            <v-list-item>
              <v-list-item-title><a href="/home">My Profile</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="/orders">My Orders</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title><a href="/orders">Account Settings</a></v-list-item-title>
            </v-list-item>
            <v-list-item>
              <v-list-item-title v-on:click="logout">Logout</v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list>
        <v-divider></v-divider>
        <!-- <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text v-on:click="logout">Logout</v-btn>
        </v-card-actions> -->
     
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
      }
    }
  }
</script>