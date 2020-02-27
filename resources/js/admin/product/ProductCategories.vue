<template>
  <div class="row">
    <div class="col-12 col-md-8">
      <v-card class="mx-0">
        <v-toolbar flat color="white">
            <v-toolbar-title>Product Categories</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="primary" @click="createItem">new</v-btn>
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
              <div class="ml-auto">
                <v-icon small @click="editItem(props.item)" class="ml-3">mdi-pencil</v-icon>
                <v-icon small @click="deleteItem(props.item)" class="ml-3">mdi-trash-can</v-icon>
              </div>
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
          Are you sure you want to delete this item?
        </v-card-text>
        <v-card-text v-if="mainAction != 'delete'">
          <v-container>
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field 
                v-model="dialogItem.product_category_title"
                label="Title"
                :rules="titleRule"
                :error="titleError"
                :error-messages="titleErrMsg"
                @change="clearAlert"
                >
              </v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dialogItem.product_category_slug"
                  label="Slug"
                  :rules="slugRule"
                  :error="slugError"
                  :error-messages="slugErrMsg"
                  @change="clearAlert"
                  >
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-combobox
                  persistent-hint
                  hint="Select Category. Leave empty to set as main category."
                  :disabled="selectDisabled"
                  :loading="selectLoading"
                  v-model="selected"
                  :items="categoryList"
                  item-text="product_category_title"
                  item-value="id"
                  label="Parent"
                  dense
                  @click="setCategoryList()"
                  >
                  <template v-slot:no-data>
                    <v-list-item>
                      <v-list-item-content>
                        <v-list-item-title>No result found</v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>
                  </template>
                  <template v-slot:append-outer>
                    <v-tooltip top color="primary" max-width="200px">
                      <template v-slot:activator="{ on }">
                        <v-btn icon v-on="on">
                          <v-icon small color="seconday">mdi-help-circle-outline</v-icon>
                        </v-btn>
                      </template>
                      <small>Select Category. Leave empty to set as main category.</small>
                    </v-tooltip>
                  </template>
                </v-combobox>
             

              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
          <!-- type='submit' -->
          <v-btn
            color="primary"
            text
            @click="save()"
            :disabled="selectDisabled"
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
      this.getProductCategoriesTree();
    },
    computed: {
    },
    watch: {
      dialog : function(val){
        if(val == false){
          this.clearAlert();
          this.$refs.form.reset();
          this.categoryList = this.allCategories;
        }
      }
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
      titleRule : [
          value => !!value || 'Required',
          value => (value && value.length < 50)  || 'Max 50 characters',
          value => (value && value.length > 1)  || 'Min 3 characters',
      ],
      slugRule :  [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 1)  || 'Min 3 characters',
      ],
      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      
      // Interface
      loading : false,
      dialog: false,

      // SnackBar
      sbType : '',
      sbText : '',
      sbStatus : false,

      // Error Handling
      errors : new ErrorBag,
      titleError : false,
      titleErrMsg : '',
      slugError : false,
      slugErrMsg : '',

      productCategories : [],
      allCategories : [],
      categoryList : [],
      selectDisabled : true,
      selectLoading : false,
      listLoaded: false,

      items: {
        text: "category_field_title",
        value: "id",
      },
      selected: [], 
      dialogItem: {
        product_category_slug: '',
        product_category_title: '',
        parent: ''
      },
      defaultItem: {
        product_category_slug: '',
        product_category_title: '',
        parent: ''
      },
      editedIndex: -1,
      editedItem: {
        product_category_slug: '',
        product_category_title: '',
      },

      // this.originalItem = Object.assign({}, item)
      formTitle : '',
    }),
    methods: {
      getParetTitle(pID){
        if(pID > 0){
          let result = this.allCategories.filter(obj => {
            return obj.id === pID;
          });
          // Assign result to selected
          this.selected = result && result[0];
        }else{
          this.selected = {
            id: 0,
            product_category_title: 'Select Category'
          }
        }
      },
      setCategoryList(){
        // get all the IDs of selected and children from the selected item
        let excludeIDs = [];
        JSON.stringify(this.dialogItem, (key, value) => {
          if (key === 'id') excludeIDs.push(value);
          return value;
        });
        let tempList = [];
        this.allCategories.map(function(item) { 
          if(!excludeIDs.includes(item.id)){
            tempList.push(item); 
          }
        });
        this.categoryList = tempList;        
      },
      editItem(i){
        this.dialogItem = Object.assign({}, i);
        this.defaultItem = Object.assign({}, i);
        this.mainAction = 'update';
        this.dialog = true;
        this.formTitle = 'Edit '+i.product_category_title;

        if(this.listLoaded == false){
          this.selectLoading = true;
          this.listLoaded = true;
          this.getProductCategoriesList(i.parent);
        }else{
          this.getParetTitle(i.parent);
        }
      },
      deleteItem(i){
        this.mainAction = 'delete';
        this.dialog = true;
        this.formTitle = 'Delete '+i.product_category_title;
      },
      clearAlert(){
          this.sbStatus = false; // SnackBar
          this.titleError = false;
          this.titleErrMsg = '';
          this.slugError = false;
          this.slugErrMsg = '';
          this.errors.clearAll();
      },
      createItem(){
        this.mainAction = 'create';
        this.dialog = true;
        this.formTitle = 'Create new';
      },
      // Get Product Categories Tree
      getProductCategoriesTree () {
        axios.get('/api/product/category/tree')
          .then(response => {
            this.productCategories = response.data;
          })
          .catch(error => {
              console.log(error.response);
              console.log('error');
          });
      },
      // Get Product Categories List
      getProductCategoriesList (pID) {
        axios.get('/api/product/category/list')
          .then(response => {
            this.allCategories = response.data;
            this.categoryList = response.data;
            this.selectLoading = false;
            this.getParetTitle(pID);
            this.selectDisabled = false;
            // console.log('list has loaded');
          })
          .catch(error => {
              console.log(error.response);
              console.log('error');
          });
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
            
            this.getProductCategoriesTree();
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
            this.getProductCategoriesTree();
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
        this.dialog = false;
      },
      save () {
        this.loading = true;
        let postData = [];
        if(this.mainAction == 'update'){
          let p = this.selected.id ? this.selected.id : 0;
          if(this.defaultItem.product_category_slug != this.dialogItem.product_category_slug){
            postData = {
              id : this.dialogItem.id,
              product_category_title : this.dialogItem.product_category_title,
              product_category_slug : this.dialogItem.product_category_slug,
              parent : p
            }
          }else{
            postData = {
              id : this.dialogItem.id,
              product_category_title : this.dialogItem.product_category_title,
              parent : p
            }
          }
          console.log(postData);
          axios.post('/admin/product/category/update', postData)
          .then(response => {
            // SnackBar
              this.sbStatus = true;
              this.sbType = 'success';
              this.sbText = response.data.message;
              this.loading = false;
              // Update Table
              this.getProductCategoriesTree();
              this.close();
              console.log('success');
              console.log(response.data);
          })
          .catch(error => {
            this.loading = false;    
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
      }
    },
  }
</script>