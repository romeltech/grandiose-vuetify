<template>
  <div>
    <v-row>
      <v-col class="col-12 col-md-3">
          <add-product-field></add-product-field>
      </v-col>
      <v-col class="col-12 col-md-8">
        <v-data-table
          :headers="headers"
          :items="pf"
          hide-default-footer
        >
          <template v-slot:top>
              <v-dialog v-model="dialog" max-width="500px">
                <v-card :loading="dialogLoading">
                  <!-- <v-card-title class="primary white--text"> -->
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field 
                            :error="updateKeyError"
                            :error-messages="updateKeyErrMsg"
                            v-model="editedItem.pf_key" 
                            :originalItem="editedItem.pf_key" 
                            label="Key">
                          </v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                          <v-text-field 
                            :error="updateValueError"
                            :error-messages="updateValueErrMsg"
                            v-model="editedItem.pf_value" 
                            label="Value">
                          </v-text-field>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="close">Cancel</v-btn>
                    <v-btn color="success" text @click="save()">Save</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
            <v-icon small @click="deleteItem(item)">mdi-trash-can</v-icon>
          </template>
          <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template>
        </v-data-table>
        <v-pagination v-if="pageCount > 1" class="mt-3" v-model="page" :length="pageCount" @input="onPageChange"></v-pagination>
      </v-col>
    </v-row>
    <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>
  </div>
</template>
<script>
  import AddProductFieldForm from '../../admin/product/AddProductFieldForm.vue';
  import SnackBar from '../../components/SnackBar.vue';
  import ErrorBag from "../../actions/errorBag.js";
  export default {
    components: {
      SnackBar,
      AddProductFieldForm
    },
    mounted (){
      this.getProductFields(1);
    },
    data: () => ({
      // Interface
      dialogLoading : false,

      // SnackBar
      sbType : '',
      sbText : '',
      sbStatus : false,

      // Error Handling
      errors : new ErrorBag,
      updateKeyError : false,
      updateKeyErrMsg : '',
      updateValueError : false,
      updateValueErrMsg : '',

      page: 1,
      pageCount: 0,
      dialog: false,
      headers: [
        { text: 'Key', value: 'pf_key', sortable: false },
        { text: 'Value', value: 'pf_value', sortable: false },
        { text: 'Actions', value: 'action', sortable: false },
      ],
      pf : [],
      // desserts: [],
      originalItem: {
        pf_key: '',
        pf_value: ''
      },
      editedIndex: -1,
      editedItem: {
        pf_key: '',
        pf_name: '',
      },
      defaultItem: {
        pf_key: '',
        pf_name: '',
      },
      formTitle : '',
    }),
    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize(){

      },
      getProductFields (thecurrentpage) {
        axios.get('/api/product/fields?page='+thecurrentpage)
          .then(response => {
            this.pf = response.data.data;
            this.page = response.data.current_page;
            this.pageCount = response.data.last_page;
          })
          .catch(error => {
              console.log(error.response);
              console.log('error');
          });
      },
      onPageChange (){
        this.getProductFields(this.page);
      },

      editItem (item) {
        // Assign Data
        this.formTitle = 'Edit '+item.pf_value
        this.editedIndex = this.pf.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.originalItem = Object.assign({}, item)
        this.dialog = true
      },
      deleteItem (item) {
        const index = this.pf.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.pf.splice(index, 1)
      },

      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        this.dialogLoading = true;
        // if (this.editedIndex > -1) {
        //   Object.assign(this.pf[this.editedIndex], this.editedItem)
        // } else {
        //   this.pf.push(this.editedItem)
        // }
        let pfdata = [];
        if(this.originalItem.pf_key === this.editedItem.pf_key){
          pfdata = {
            id : this.editedItem.id,
            pf_value : this.editedItem.pf_value            
          }
        }else{
          pfdata = {
            id : this.editedItem.id,
            pf_key : this.editedItem.pf_key,
            pf_value : this.editedItem.pf_value
          };
        }
        axios.post('/admin/product/fields/update', pfdata)
        .then(response => {
            // SnackBar
            this.sbStatus = true;
            this.sbType = 'success';
            this.sbText = response.data.message;

            // this.loading = false;
            // this.responseMessage = response.data.message;
            // console.log(response.data.message);
            // console.log('success meh');
            // this.errors.clearAll();
            // this.$refs.form.reset();
            // this.keyError = false;
            // this.valueError = false;
            this.getProductFields(this.page);
            this.dialogLoading = false;    
            this.close();
            console.log('success');
            console.log(response.data);
        })
        .catch(error => {
          this.dialogLoading = false;    
          if (error.response && error.response.status == 422) {
              this.errors.setErrors( error.response.data.errors );
              // SnackBar
              this.sbStatus = true;
              this.sbType = 'error';
              this.sbText = 'Error adding product field';

              // Input error messages
              if(this.errors.hasError('pf_key') ){
                  this.updateKeyError = true;
                  this.updateKeyErrMsg = this.errors.first('pf_key');
              }
              if(this.errors.hasError('pf_value') ){
                  this.updateValueError = true;
                  this.updateValueErrMsg = this.errors.first('pf_value');
              }
          }
        });

      },
    },
  }
</script>