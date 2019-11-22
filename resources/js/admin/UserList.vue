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
                <v-btn icon @click="deleteUser(item)">
                  <v-icon small>delete</v-icon>
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

        <template>
          <v-snackbar
            v-model="snackbar"
            :color="snackbarColor"
          >
            {{ snackbarMessage }}
            <v-btn
              color="white"
              text
              @click="snackbar = false"
            >
              Close
            </v-btn>
          </v-snackbar>
        </template>

    </div>
</template>

<script>
  export default {
    props : ['usersList'],
    data () {
      return {
        dialog: false,
        toDelete : [],
        loading: false,
        snackbar: false,
        snackbarColor: '',
        snackbarMessage: '',

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
        axios.delete('/admin/user/destroy/'+confirmedDeleteUser.id)
        .then(response => {
          setTimeout(() => { 
            const index = this.users.indexOf(confirmedDeleteUser);
            this.users.splice(index, 1);
            this.dialog = false;
            this.loading = false;
            this.snackbar = true;
            this.snackbarColor = 'success';
            this.snackbarMessage = response.data.message; 
          }, 300);
        })
        .catch(error => {
            this.dialog = false;
            this.loading = false;
            this.snackbar = true;
            this.snackbarColor = 'red';
            this.snackbarMessage = 'Error deleting user';
            console.log(error.response);
        });
      }     
    },
  }
</script>