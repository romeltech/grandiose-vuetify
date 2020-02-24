<template>
  <div>
    <!-- selection-type="independent"
    selectable -->
    <v-card class="mx-0">
      <v-treeview
        dense
        selected-color="primary"
        :items="productCategories"
        open-on-click
        >
        <template slot="label" slot-scope="props">
            {{props.item.product_category_title}}
            <!-- {{item.id}} -->
               <!-- {{ item.product_category_title }} -->
        </template>
      </v-treeview>
    </v-card>
  <!-- <v-data-table
    :headers="headers"
    :items="this.getChildren(productCategories,0)"
    :single-expand="singleExpand"
    :expanded.sync="expanded"
    item-key="name"
    show-expand
    hide-default-footer
  >
    <template v-slot:expanded-item="{ headers }">
      <td :colspan="headers.length">Peek-a-boo!</td>
    </template>
  </v-data-table> -->

    <!-- <v-card>
      <v-list dense> -->

        <!-- <div v-for="(pc, i) in productCategories" :key="i">
          <v-list-item v-if="pc.parent == 0" style="border-bottom: 1px solid #eee;">
            <v-list-item-title >{{pc.product_category_title}}</v-list-item-title>
          </v-list-item>
        </div> -->

        

          <!-- <v-list-item v-for="(pc, i) in this.getChildren(productCategories,0)" :key="i">
            <v-list-item-title >{{pc.product_category_title}}</v-list-item-title>
          </v-list-item> -->
          <!-- <v-list-item v-if="productCategories.parent == 0">
            <v-list-item-title >{{pc.product_category_title}}</v-list-item-title>
          </v-list-item>
          -->

      <!-- </v-list>
    </v-card> -->

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
    computed: {
      // mainCategories: function(){
      //   return this.productCategories.filter(function(u) {
      //     return u.parent == 0;
      //   })
      // },
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
            console.log(this.productCategories);
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