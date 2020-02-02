<template>
  <div>
    <v-row>
      <v-col class="col-12 col-md-3">
          <v-card
            flat
            :loading="loading">
            <v-form
                class="pa-5"
                @submit.prevent="addProductCategory()"
                v-model="valid"
                method="POST"
                ref="form"
                lazy-validation>
                <v-text-field
                  dense
                  :rules="fieldnamerule"
                  v-model="fieldname"
                  outlined
                  required
                  id="field"
                  type="text"
                  name="field"
                  label="Title"
                  :error="keyError"
                  :error-messages="keyErrorMessage"
                  @change="clearAlert"
                  >
                </v-text-field>
                <v-text-field
                  dense
                  :rules="fieldvaluerule"
                  v-model="fieldvalue"
                  outlined
                  required
                  id="fieldvalue"
                  type="text"
                  name="fieldvalue"
                  label="Slug"
                  :error="valueError"
                  :error-messages="valueErrorMessage"
                  >
                </v-text-field>
                <v-btn
                  @click="clearAlert()"
                  width="100%"
                  dense
                  color="primary"
                  class="mb-2"
                  type="submit">
                  Save
                </v-btn>
            </v-form>
        </v-card>
      </v-col>
      <v-col class="col-12 col-md-8">
        <v-data-table
          :headers="headers"
          :items="pf"
          hide-default-footer
        >
          <template v-slot:item.product_category_title="{ item }">
            <tr>
              <td style="cursor:pointer;border:0;">
                <a v-bind:href="'/admin/product/category/field/'+item.product_category_slug">{{ item.product_category_title }}</a>
              </td>
            </tr>
          </template>
          <template v-slot:top>
            <v-dialog v-model="dialog" max-width="500px">
              <v-card :loading="dialogLoading">
                <v-card-title class="primary white--text">
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="6">
                        <v-text-field 
                          :rules="fieldvaluerule"
                          :error="updateValueError"
                          :error-messages="updateValueErrMsg"
                          v-model="editedItem.product_category_title" 
                          label="Title">
                        </v-text-field>
                      </v-col>
                      <v-col cols="12" sm="6" md="6">
                        <v-text-field
                          :rules="fieldnamerule"
                          :error="updateKeyError"
                          :error-messages="updateKeyErrMsg"
                          v-model="editedItem.product_category_slug" 
                          :originalItem="editedItem.product_category_slug" 
                          label="Slug">
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
  
            <v-dialog v-model="deleteDialog" persistent max-width="400">
              <v-card :loading="deleteLoading">
                <v-card-title class="headline">Confirm Deletion</v-card-title>
                <v-card-text>Do you want to delete the account of <strong>{{formTitle}}</strong>?</v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" text @click="deleteDialog = false">Cancel</v-btn>
                  <v-btn color="red" text @click="confirmDelete(toDelete)">Delete</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
            <v-icon small @click="toDeleteItem(item)">mdi-trash-can</v-icon>
          </template>
        </v-data-table>

        <v-pagination v-if="pageCount > 1" class="mt-3" v-model="page" :length="pageCount" @input="onPageChange"></v-pagination>
      </v-col>
    </v-row>
    <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>
  </div>
</template>
<script>
  import SnackBar from '../../components/SnackBar.vue';
  import ErrorBag from "../../actions/errorBag.js";
  export default {
    components: {
      SnackBar
    },
    mounted (){
      this.getProductCategories(1);
    },
    data: () => ({
      // Delete a Category
      toDelete : [],

      // Add a Category
      fieldname: '',
      fieldvalue: '',
      
      // rules
      valid : true,
      fieldnamerule : [
          value => !!value || 'Required',
          value => (value && value.length < 50)  || 'Max 50 characters',
          value => (value && value.length > 3)  || 'Min 3 characters',
      ],
      fieldvaluerule :  [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 3)  || 'Min 3 characters',
      ],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      
      // Interface
      loading : false,
      dialogLoading : false,
      deleteLoading : false,
      deleteDialog : false,
      dialog: false,

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

      // Error Handling
      keyError : false,
      keyErrorMessage : '',
      valueError : false,
      valueErrorMessage : '',

      page: 1,
      pageCount: 0,

      headers: [
        { text: 'Title', value: 'product_category_title', sortable: false, width: '40%', align: 'left' },
        { text: 'Slug', value: 'product_category_slug', sortable: false, width: '40%', align: 'left' },
        { text: 'Actions', value: 'action', sortable: false, width: '20%', align: 'right' },
      ],
      pf : [],
      originalItem: {
        product_category_slug: '',
        product_category_title: ''
      },
      editedIndex: -1,
      editedItem: {
        product_category_slug: '',
        product_category_title: '',
      },
      defaultItem: {
        product_category_slug: '',
        product_category_title: '',
      },
      formTitle : '',
    }),
    methods: {
      clearAlert(){
          this.sbStatus = false; // SnackBar
          this.keyError = false;
          this.keyErrorMessage = '';
          this.valueError = false;
          this.valueErrorMessage = '';
          this.updateKeyError = false,
          this.updateKeyErrMsg = '',
          this.updateValueError = false,
          this.updateValueErrMsg = '',
          this.errors.clearAll();
      },
      // Get Product Categories
      getProductCategories (thecurrentpage) {
        axios.get('/api/product/categories?page='+thecurrentpage)
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
      // update table
      onPageChange (){
        this.getProductCategories(this.page);
      },
      // Add Products
      addProductCategory(){
        this.loading = true;
        axios.post('/admin/product/category/store', {
            product_category_slug : this.fieldname,
            product_category_title : this.fieldvalue
        })
        .then(response => {
            // SnackBar
            this.sbStatus = true;
            this.sbType = 'success';
            this.sbText = response.data.message;
            this.loading = false;
            
            this.getProductCategories(this.page);
            this.$refs.form.reset();

        })
        .catch(error => {
            this.loading = false;
            if(error.response.status == 403){
              // SnackBar
              this.sbStatus = true;
              this.sbType = 'error';
              this.sbText = error.response.data.errorMessage;
              console.log(error.response.data.errorMessage);
            }
            if (error.response && error.response.status == 422) {
                this.errors.setErrors( error.response.data.errors );
                // SnackBar
                this.sbStatus = true;
                this.sbType = 'error';
                this.sbText = 'Error adding product category';
                // Input error messages
                if(this.errors.hasError('product_category_slug') ){
                    this.keyError = true;
                    this.keyErrorMessage = this.errors.first('product_category_slug');
                }
                if(this.errors.hasError('product_category_title') ){
                    this.valueError = true;
                    this.valueErrorMessage = this.errors.first('product_category_title');
                }
            }
        });
      },

      editItem (item) {
        this.clearAlert();
        // Assign Data
        this.formTitle = 'Edit '+item.product_category_title
        this.editedIndex = this.pf.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.originalItem = Object.assign({}, item)
        this.dialog = true
      },
      toDeleteItem (item) {
        this.toDelete = item;
        this.deleteDialog = true;
        this.formTitle = item.product_category_slug;
      },
      confirmDelete(toDelete){
        this.deleteLoading = true,
        console.log(this.toDelete);
        
        axios.delete('/admin/product/category/destroy/'+toDelete.id)
        .then(response => {
            this.deleteLoading = false,
            // SnackBar
            this.sbStatus = true;
            this.sbType = 'success';
            this.sbText = response.data.message;
            this.deleteDialog = false;
            this.getProductCategories(this.page);
        })
        .catch(error => {
          this.deleteLoading = false;
          this.deleteDialog = false;  
          this.sbStatus = true;
          this.sbType = 'error';
          if (error.response && error.response.status == 422) {
            this.errors.setErrors( error.response.data.errors );
            this.sbText = 'Response Error';
          }else{
            this.sbText = 'Error adding product category';
          }
        });
      },
      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      save () {
        this.dialogLoading = 'secondary';
        let pfdata = [];
        if(this.originalItem.product_category_slug === this.editedItem.product_category_slug){
          pfdata = {
            id : this.editedItem.id,
            product_category_title : this.editedItem.product_category_title            
          }
        }else{
          pfdata = {
            id : this.editedItem.id,
            product_category_slug : this.editedItem.product_category_slug,
            product_category_title : this.editedItem.product_category_title
          };
        }
        axios.post('/admin/product/category/update', pfdata)
        .then(response => {
            // SnackBar
            this.sbStatus = true;
            this.sbType = 'success';
            this.sbText = response.data.message;
            // Update Table
            this.getProductCategories(this.page);
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
              this.sbText = 'Error adding product category';
              // Input error messages
              if(this.errors.hasError('product_category_slug') ){
                  this.updateKeyError = true;
                  this.updateKeyErrMsg = this.errors.first('product_category_slug');
              }
              if(this.errors.hasError('product_category_title') ){
                  this.updateValueError = true;
                  this.updateValueErrMsg = this.errors.first('product_category_title');
              }
          }
        });
      }
    },
  }
</script>