<template>
  <div class="row">
    <div class="col-12 col-md-8">
      <v-card class="mx-0">
        <v-toolbar flat color="white">
            <v-toolbar-title>Product Categories</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="primary" @click="create">new</v-btn>
        </v-toolbar>
        <v-treeview
          hoverable
          selected-color="primary"
          :items="productCategories" class="pb-3"
          >
          <template slot="label" slot-scope="props">
            <div class="d-flex px-3">
              <span>
                {{props.item.product_category_title}}
              </span>
              <v-icon small @click="edit(props.item)" class="ml-auto">mdi-pencil</v-icon>
            </div>
          </template>
        </v-treeview>
      </v-card>
      <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>
    </div>

  
    <v-dialog v-model="dialog" max-width="500px">
      <v-card :loading="loading">
      <v-form
        method="POST"
        ref="form"
        v-model="valid"
        @submit.prevent="save(dialogItem)"
        lazy-validation>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text v-if="mainAction == 'delete'">
          Are you sure you want to delete <strong>{{toDeleteTitle}}</strong>?
        </v-card-text>
        <v-card-text v-if="mainAction != 'delete'">
          <v-container>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field 
                v-model="dialogItem.category_field_title"
                label="Title"
                :rules="titleRule"
                :error="titleError"
                :error-messages="titleErrorMessage"
                @change="clearAlert"
                >
              </v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field 
                  v-model="dialogItem.category_field_slug"
                  label="Slug"
                  :rules="slugRule"
                  :error="slugError"
                  :error-messages="slugErrorMessage"
                  @change="clearAlert"
                  >
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <v-btn
            v-if="dialogAction = 1"
            color="primary"
            text
            type="submit"
          >{{mainAction}}</v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    
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
    computed: {
      // mainCategories: function(){
      //   return this.productCategories.filter(function(u) {
      //     return u.parent == 0;
      //   })
      // },
    },
    data: () => ({
      // Dialog
      mainAction : '',


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


      expanded: [],
      singleExpand: false,
      headers: [
        { text: 'Title', value: 'product_category_title', sortable: false, width: 'auto', align: 'left' },
        { text: 'Slug', value: 'product_category_slug', sortable: false, width: '30%', align: 'left' },
        { text: 'Parent', value: 'parent', sortable: false, width: '10%', align: 'left' },
        { text: 'Actions', value: 'action', sortable: false, width: '10%', align: 'right' },
      ],
      productCategories : [],
      parentCategories : [],
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
      create(){
        this.mainAction = 'create';
        this.dialog = true;
        this.formTitle = 'Create new';
      },
      edit(i){
        this.mainAction = 'edit';
        this.dialog = true;
        this.formTitle = 'Edit '+i.product_category_title;
        console.log(i);
      },
      getChildren(obj, p){
        return obj.filter(function(o) {
          return o.parent == p;
        })
      },
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
        // axios.get('/api/product/categories?page='+thecurrentpage)
        axios.get('/api/product/categories')
          .then(response => {
            // this.productCategories = response.data.data;
            this.productCategories = response.data;
            // console.log(this.productCategories);
            // this.page = response.data.current_page;
            // this.pageCount = response.data.last_page;
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