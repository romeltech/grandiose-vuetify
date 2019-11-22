<template>
    <div>
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    label="Search"
                    single-line
                    hide-details
                    append-icon="search"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="users"
                :items-per-page="10"
                :search="search"
            >
              <template v-slot:item.role="{ item }">
                  ({{item.role}}) {{displayRole(item.role)}}
              </template>

              <template v-slot:item.action="{ item }">
                <v-btn icon :href="'users/edit/'+item.id">
                  <v-icon small>edit</v-icon>
                </v-btn>
                <v-btn icon :href="'users/edit/'">
                  <!-- @click="deleteItem(item)" -->
                  <v-icon small>delete</v-icon>
                </v-btn>
              </template>

            </v-data-table>
        </v-card>
    </div>
</template>

<script>
  export default {
    props : ['usersList'],
    data () {
      return {
        search: '',
        users: this.usersList.data,
        headers: [
          { text: 'Name', value: 'name', align: 'left', sortable: true },
          { text: 'Email', value: 'email' },
          { text: 'Role', value: 'role' },
          { text: 'Action', value: 'action', sortable: false, },
        ],
      }
    },
    methods: {
      displayRole (role){
        if(role == 1) return 'Super Admin'
        else if(role == 2) return 'Admin'
        else if(role == 3) return 'Store Admin'
        else if(role == 4) return 'Delivery Person'
        else if(role == 5) return 'Customer'
      },
      // deleteUser (item) {
      //   console.log(item.id);
      //   // this.editedIndex = this.desserts.indexOf(item)
      //   // this.editedItem = Object.assign({}, item)
      //   // this.dialog = true
      // },
    },
    // mounted(){
    //     console.log(this.usersList);
    // },
  }
</script>