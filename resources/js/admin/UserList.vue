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
                :items-per-page="5"
                :search="search"
            >
            <!-- <template v-slot:item.role="{ item }">
                ({{item.role}}) {{displayRole(item.role)}}
            </template> -->
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
  export default {

    props : ['users'],
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: true,
            value: 'name',
          },
          { text: 'Email', value: 'email' },
          { text: 'Role', value: 'role' },
        ],
      }
    },
    // methods: {
    //     displayRole (role){
    //         if(role == 1) return 'Super Admin'
    //         else if(role == 2) return 'Admin'
    //         else if(role == 3) return 'Store Admin'
    //         else if(role == 4) return 'Delivery Person'
    //         else if(role == 5) return 'Customer'
    //     }
    // }
    mounted(){
        console.log(users);
    },
  }
</script>