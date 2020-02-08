<template>
  <div>
    <v-row>
      <v-col class="col-12 col-md-8">
        <v-data-table
          :headers="headers"
          :items="categoryFields"
          :page.sync="page"
          :items-per-page="itemsPerPage"
          hide-default-footer
          class="elevation-1"
        >
          <!-- @page-count="pageCount = $event" -->
          <template v-slot:top>
            <v-toolbar flat color="white">
              <v-toolbar-title>{{tableTitle}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn class="primary"  @click="newItem">new</v-btn>
              <v-dialog v-model="dialog" max-width="500px">
                <v-card :loading="loading">
                  <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                  </v-card-title>

                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col cols="12" md="6">
                          <v-text-field v-model="dialogItem.category_field_title" label="Title"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                          <v-text-field v-model="dialogItem.category_field_slug" label="Slug"></v-text-field>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                    <v-btn v-if="dialogAction = 1" color="blue darken-1" text @click="save(dialogItem)">{{mainAction}}</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>

            </v-toolbar>
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
    props : ['productCategory'],
    data () {
      return {
        // SnackBar
        sbType : '',
        sbText : '',
        sbStatus : false,

        // Error Handling
        errors : new ErrorBag,

        // Form
        formTitle : '',
        valid : false,
        metaTitle : '',
        metaTitleRules : '',
        mainAction : '',
        
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        // Dialog
        loading : false,
        dialog : false,
        dialogAction : '',

        // Edit
        dialogItem: [],

        // Product Category objecy
        pCategory : this.productCategory,

        // Data Table
        categoryFields : [],
        tableTitle : '',
        itemsPerPage : 10,
        page: 1,
        pageCount: 0,
        headers: [
          { text: 'Title', value: 'category_field_title', width: '40%', align: 'left' },
          { text: 'Slug', value: 'category_field_slug', width: '40%', align: 'left' },
          { text: 'Actions', value: 'action', sortable: false, width: '20%', align: 'right' },
        ],
      }
    },
    mounted (){
      this.getCategoryFields(1);
      this.tableTitle = this.productCategory.product_category_title;
    },
    methods: {
      getCategoryFields(p){
        // Get the data 
        axios.get('/api/product/category/fields/'+this.pCategory.id+'?page='+p)
        .then(response => {
          this.categoryFields = response.data.data;
          this.page = response.data.current_page;
          this.pageCount = response.data.last_page;
        })
        .catch(error => {
          console.log('Error: '+error);
        });
      },
      onPageChange (){
        this.getCategoryFields(this.page);
      },
      newItem(){
        this.mainAction = 'create'; 
        this.dialog = true;
        this.formTitle = 'New Item';
        this.dialogAction = 1;
        this.dialogItem = [];
      },
      editItem(item){
        this.dialog = true;
        this.formTitle = 'Edit '+item.category_field_title;
        this.dialogAction = 2;
        this.mainAction = 'update';
        console.log(this.mainAction);
        // Assign Data
        this.dialogItem = Object.assign({}, item);
        // this.originalItem = Object.assign({}, item)
        console.log(this.dialogItem);
      },
      save(dialogItem){
        this.loading = false;
        // Create Category Fields
        if(this.mainAction === 'create'){
          // console.log(this.dialogItem.category_field_title);
          this.loading = true;
          axios.post('/admin/product/category/field/store', {
              product_category_id : this.productCategory.id,
              category_field_slug : this.dialogItem.category_field_slug,
              category_field_title : this.dialogItem.category_field_title
          })
          .then(response => {
              // SnackBar
              this.sbStatus = true;
              this.sbType = 'success';
              this.sbText = response.data.message;
              this.loading = false;

              this.dialog = false;
              
              this.getCategoryFields(this.page);
              // this.$refs.form.reset();

          })
          .catch(error => {
              this.loading = false;
              if(error.response.status == 403){
              }
              // console.log(error);
          });
        }
        else if(this.mainAction === 'update'){
          console.log(this.mainAction);
        }
      },
      deleteItem(itemToDelete){
        console.log(itemToDelete);
      },
      close(){
        this.dialog = false
      }
    }
  }
</script>