<template>
  <div class="row">
    <div class="col-12">
      <v-card class="mx-0 py-2">
        <v-toolbar flat color="white">
          <v-toolbar-title class="d-none d-md-block d-lg-block">Categories</v-toolbar-title>
          <v-icon class="d-none d-sm-block d-md-none">mdi-basket</v-icon>
          <v-spacer></v-spacer>
          <v-autocomplete  v-if="searchStatus == true"
            :items="allCategories"
            :filter="customFilter"
            label="Search a category"
            item-text="title"
            hide-details
            dense
            class="pa-2"
            style="width:300px;"
            clearable
            clear-icon="mdi-broom"
          >
           <template v-slot:item="{ item }">
              <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
              </v-list-item-content>
              <v-list-item-action>
                <span>
                  <v-icon small @click="editItem(item)">mdi-pencil</v-icon>
                  <v-icon small @click="deleteItem(item)">mdi-trash-can</v-icon>
                </span>
              </v-list-item-action>
          </template>
          </v-autocomplete>
            <v-icon :searchStatus="false" @click="openSearch" class="pr-3">{{ searchIcon }}</v-icon>
          <v-btn class="primary" @click="createItem">new</v-btn>
        </v-toolbar>
        <v-treeview
          hoverable
          selected-color="primary"
          :items="productCategories"
          >
          <template slot="label" slot-scope="props">
            <div class="d-flex px-3">
              <span>
                {{props.item.title}}
              </span>
              <div class="ml-auto">
                <v-icon small @click="editItem(props.item)" class="ml-3">mdi-pencil</v-icon>
                <v-icon v-bind:disabled="props.item.children? true : false" small @click="deleteItem(props.item)" class="ml-3">mdi-trash-can</v-icon>
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
                v-model="dialogItem.title"
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
                  v-model="dialogItem.slug"
                  label="Slug"
                  :rules="slugRule"
                  :error="slugError"
                  :error-messages="slugErrMsg"
                  @change="clearAlert"
                  @mousedown="generateSlug"
                  @focus="generateSlug"
                  >
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-combobox
                  persistent-hint
                  hint="Select a parent category. Leave empty to set as main category."
                  :disabled="selectDisabled"
                  :loading="selectLoading"
                  v-model="selected"
                  :items="categoryList"
                  item-text="title"
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
                      <span>Set a parent category by clicking on the dropdown selection. Leave empty to set as main category.</span>
                    </v-tooltip>
                  </template>
                </v-combobox>

              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
          <!-- type='submit' -->
          <v-btn
            color="primary"
            text
            @click="save()"
            :disabled="!valid"
          >{{mainAction}}</v-btn>
            <!-- :disabled="selectDisabled" -->
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
          this.dialogItem.title = '';
          this.dialogItem.slug = '';
          this.dialogItem.parent = 0;
        }
      }
    },
    data: () => ({
      allCategoriesLoded: false,
      searchStatus : false,
      searchIcon : 'mdi-magnify',
      search: '',

      // Dialog
      mainAction : '',

      // rules
      valid : true,
      titleRule : [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 1)  || 'Min 1 characters',
      ],
      slugRule :  [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 1)  || 'Min 1 characters',
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

      // Tree
      productCategories : [],
      allCategories : [],
      categoryList : [],
      selectDisabled : true,
      selectLoading : false,
      listLoaded: false,
      selected: [], 

      dialogItem: {
        slug: '',
        title: '',
        parent: 0
      },
      defaultItem: {
        slug: '',
        title: '',
        parent: 0
      },
      formTitle : '',
      // Delete a Category
      deleteID : 0,
    }),
    methods: {
      customFilter (item, queryText, itemText) {
        const textOne = item.title.toLowerCase()
        const textTwo = item.title.toLowerCase()
        const searchText = queryText.toLowerCase()

        return textOne.indexOf(searchText) > -1 ||
          textTwo.indexOf(searchText) > -1
      },
      openSearch(){
        if(this.searchStatus == true){
          this.searchStatus = false;
          this.searchIcon = 'mdi-magnify';
        }else{
          this.searchStatus = true;
          this.searchIcon = 'mdi-close';
        }
        if(this.allCategoriesLoded == false){
          this.getProductCategoriesList(0);
        }else{
          console.log(this.allCategories);
        }
        console.log(this.productCategories);
        console.log(this.searchStatus);
      },
      generateSlug(){
        this.dialogItem.slug = this.dialogItem.title && slugify(this.dialogItem.title);
      },
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
            title: 'Select Category'
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
        this.formTitle = 'Edit '+i.title;

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
        this.formTitle = 'Delete '+i.title;
        this.deleteID = i.id;
      },
      successUI(msg){
        // Dialog
        this.dialog = false;
        this.loading = false;
        // SnackBar
        setTimeout(() => {
          this.sbStatus = true;
          this.sbType = 'success';
          this.sbText = msg;
        }, 100);
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
        console.log(this.dialogItem);
        this.mainAction = 'create';
        this.dialog = true;
        this.formTitle = 'Create new';
        this.getProductCategoriesList(0);
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
            this.allCategoriesLoded = true;
            // console.log('list has loaded');
          })
          .catch(error => {
              console.log(error.response);
              console.log('error');
          });
      },
      save () {
        this.valid = false;
        this.loading = true;
        // Update
        if(this.mainAction == 'update'){
          let postData = [];
          let p = this.selected.id ? this.selected.id : 0;
          if(this.defaultItem.slug != this.dialogItem.slug){
            postData = {
              id : this.dialogItem.id,
              title : this.dialogItem.title,
              slug : this.dialogItem.slug,
              parent : p
            }
          }else{
            postData = {
              id : this.dialogItem.id,
              title : this.dialogItem.title,
              parent : p
            }
          }
          axios.post('/admin/product/category/update', postData)
          .then(response => {
            // Update Table
            this.getProductCategoriesTree();
            this.getProductCategoriesList(0);
            this.successUI(response.data.message);
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
              if(this.errors.hasError('slug') ){
                this.updateKeyError = true;
                this.updateKeyErrMsg = this.errors.first('slug');
              }
              if(this.errors.hasError('title') ){
                this.updateValueError = true;
                this.updateValueErrMsg = this.errors.first('title');
              }
            }
          });
        }else if(this.mainAction == 'create'){
          // Create
          this.loading = true;
          let title = this.dialogItem.title && this.dialogItem.title.trim();
          axios.post('/admin/product/category/store', {
            slug : this.dialogItem.slug,
            title : title,
            parent : this.selected.id
          })
          .then(response => {
            this.getProductCategoriesTree();
            this.getProductCategoriesList(0);
            this.successUI(response.data.message);
          })
          .catch(error => {
            this.loading = false;
            // if(error.response.status == 403){
            if(error.response.status == 403){
              // SnackBar
              this.sbStatus = true;
              this.sbType = 'error';
              this.sbText = error;
              console.log(error);
            }
            if (error.response && error.response.status == 422) {
              this.errors.setErrors( error.response.data.errors );
              // SnackBar
              this.sbStatus = true;
              this.sbType = 'error';
              this.sbText = 'Error adding product category';
              // Input error messages
              if(this.errors.hasError('slug') ){
                this.slugError = true;
                this.slugErrMsg = this.errors.first('slug');
              }
              if(this.errors.hasError('title') ){
                this.titleError = true;
                this.titleErrMsg = this.errors.first('title');
              }
            }
          });
        }else if(this.mainAction == 'delete'){
          axios.delete('/admin/product/category/destroy/'+this.deleteID)
          .then(response => {
            this.successUI(response.data.message);
            this.getProductCategoriesList(0);
            this.getProductCategoriesTree();
          })
          .catch(error => {
            this.loading = false;  
            this.dialog = false;
            // SnackBar
            setTimeout(() => {
              this.sbStatus = true;
              this.sbType = 'error';
              if (error.response && error.response.status == 422) {
                this.errors.setErrors( error.response.data.errors );
                this.sbText = error.response.data.message;
              }else{
                this.sbText = 'Error deleting product category';
              }
            }, 100);
          });
        }

      }
    },
  }
</script>