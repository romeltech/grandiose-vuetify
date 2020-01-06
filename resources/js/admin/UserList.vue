<template>
  <div>
      <v-card>
        <v-card-title>
            <v-text-field
                v-model="search"
                label="Search"
                single-line
                hide-details
                append-icon="mdi-magnify"
            >
            </v-text-field>
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
              <v-icon small>mdi-pencil</v-icon>
            </v-btn>
            <v-btn icon @click="deleteUser(item)">
              <v-icon small>mdi-delete</v-icon>
            </v-btn>
          </template>

        </v-data-table>

        <template>
          <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="400">
              <v-card :loading="loading">
                <v-card-title class="headline">Confirm Deletion</v-card-title>
                <v-card-text>Do you want to delete the account of {{toDelete.name}}?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" text @click="dialog = false">Cancel</v-btn>
                  <v-btn color="red" text @click="confirmDelete(toDelete)">Delete</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-row>
        </template>

      </v-card>
      
      <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>

  </div>
</template>

<script>
  import SnackBar from '../components/SnackBar.vue';
  
  export default {
    components: {
      SnackBar
    },
    props : ['usersList'],
    data () {
      return {

        // SnackBar
        sbType : '',
        sbText : '',
        sbStatus : false,

        dialog: false,
        toDelete : [],
        loading: false,

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
      deleteUser (userToDelete) {
        this.dialog = true;
        this.toDelete = userToDelete;
      },
      confirmDelete (confirmedDeleteUser){
        this.loading = true;
        this.sbStatus = false; // SnackBar
        axios.delete('/admin/user/destroy/'+confirmedDeleteUser.id)
        .then(response => {
          setTimeout(() => { 
            const index = this.users.indexOf(confirmedDeleteUser);
            this.users.splice(index, 1);
            this.dialog = false;
            this.loading = false;

            // SnackBar
            this.sbStatus = true;
            this.sbType = 'success';
            this.sbText = response.data.message;
            
          }, 300);
        })
        .catch(error => {
            this.dialog = false;
            this.loading = false;

            // SnackBar
            this.sbStatus = true;
            this.sbType = 'error';
            this.sbText = 'Error deleteing user.';

            console.log(error.response);
        });
      }     
    },
  }
</script>