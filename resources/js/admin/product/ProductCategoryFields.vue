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
              <v-btn class="primary" @click="newItem">new</v-btn>
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
                    <!-- @click="save(dialogItem)" -->
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
            </v-toolbar>
          </template>
          <template v-slot:item.action="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
            <v-icon small @click="toDeleteItem(item)">mdi-trash-can</v-icon>
          </template>
        </v-data-table>
        <v-pagination
          v-if="pageCount > 1"
          class="mt-3"
          v-model="page"
          :length="pageCount"
          @input="onPageChange"
        ></v-pagination>
      </v-col>
    </v-row>
    <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>
  </div>
</template>

<script>
import SnackBar from "../../components/SnackBar.vue";
import ErrorBag from "../../actions/errorBag.js";
export default {
  components: {
    SnackBar
  },
  props: ["productCategory"],
  data() {
    return {
      // SnackBar
      sbType: "",
      sbText: "",
      sbStatus: false,

      // Error Handling
      errors: new ErrorBag(),
      slugError: false,
      slugErrorMessage: '',
      titleError: false,
      titleErrorMessage: '',

      valid : true,
      titleRule : [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 3)  || 'Min 3 characters',
      ],
      slugRule :  [
        value => !!value || 'Required',
        value => (value && value.length < 50)  || 'Max 50 characters',
        value => (value && value.length > 3)  || 'Min 3 characters',
      ],

      // Form
      formTitle: "",
      valid: false,
      metaTitle: "",
      metaTitleRules: "",
      mainAction: "",
      toDeleteTitle : "",

      csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),

      // Dialog
      loading: false,
      dialog: false,
      dialogAction: "",

      // Edit
      dialogItem: [],
      originalItem: [],

      // Product Category objecy
      pCategory: this.productCategory,

      // Data Table
      categoryFields: [],
      tableTitle: "",
      itemsPerPage: 10,
      page: 1,
      pageCount: 0,
      headers: [
        {
          text: "Title",
          value: "category_field_title",
          width: "40%",
          align: "left"
        },
        {
          text: "Slug",
          value: "category_field_slug",
          width: "40%",
          align: "left"
        },
        {
          text: "Actions",
          value: "action",
          sortable: false,
          width: "20%",
          align: "right"
        }
      ]
    };
  },
  mounted() {
    this.getCategoryFields(1);
    this.tableTitle = this.productCategory.product_category_title;
  },
  watch: {
    dialog() {
      if(this.dialog == false){
        this.$refs.form.reset();
      }
    }
  },
  methods: {
    clearAlert(){
      this.sbStatus = false;
      this.errors.clearAll();
      this.slugError = false;
      this.slugErrorMessage = '';
      this.titleError = false;
      this.titleErrorMessage ='';
      // console.log(this.slugError);
    },
    getCategoryFields(p) {
      // Get the data
      axios
        .get("/api/product/category/fields/" + this.pCategory.id + "?page=" + p)
        .then(response => {
          this.categoryFields = response.data.data;
          this.page = response.data.current_page;
          this.pageCount = response.data.last_page;
        })
        .catch(error => {
          console.log("Error: " + error);
        });
    },
    onPageChange() {
      this.getCategoryFields(this.page);
    },
    newItem() {
      this.clearAlert();
      this.mainAction = "create";
      this.dialog = true;
      this.formTitle = "New Item";
      this.dialogAction = 1;
      this.dialogItem = [];
    },
    editItem(item) {
      this.clearAlert();
      this.dialog = true;
      this.formTitle = "Edit " + item.category_field_title;
      this.dialogAction = 2;
      this.mainAction = "update";
      // console.log(this.mainAction);
      // Assign Data
      this.dialogItem = Object.assign({}, item);
      this.originalItem = Object.assign({}, item);
      console.log(this.dialogItem);
    },
    save(dialogItem) {
      this.loading = false;
      // Create Category Fields
      if (this.mainAction === "create") {
        // console.log(this.dialogItem.category_field_title);
        this.loading = true;
        axios
          .post("/admin/product/category/field/store", {
            product_category_id: this.productCategory.id,
            category_field_slug: this.dialogItem.category_field_slug,
            category_field_title: this.dialogItem.category_field_title
          })
          .then(response => {
            // SnackBar
            this.sbStatus = true;
            this.sbType = "success";
            this.sbText = response.data.message;
            this.loading = false;

            this.dialog = false;

            this.getCategoryFields(this.page);
            // this.$refs.form.reset();
          })
          .catch(error => {
            this.loading = false;
            if (error.response.status == 403) {
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
              if(this.errors.hasError('category_field_slug') ){
                  this.slugError = true;
                  this.slugErrorMessage = this.errors.first('category_field_slug');
              }
              if(this.errors.hasError('category_field_title') ){
                  this.titleError = true;
                  this.titleErrorMessage = this.errors.first('category_field_title');
              }
            }
          });
      }else if (this.mainAction === "update") {
        this.loading = true;

        console.log('original item: '+this.originalItem.category_field_slug);
        console.log('dialogItem item: '+this.dialogItem.category_field_slug);

        let updateData = [];
        if(this.originalItem.category_field_slug != this.dialogItem.category_field_slug){
          updateData = {
            id: this.dialogItem.id,
            product_category_id: this.productCategory.id,
            category_field_slug: this.dialogItem.category_field_slug,
            category_field_title: this.dialogItem.category_field_title,      
          }
        }else{
          updateData = {
            id: this.dialogItem.id,
            product_category_id: this.productCategory.id,
            category_field_title: this.dialogItem.category_field_title,
          };
        }

        axios
        .post('/admin/product/category/field/update', updateData)
        .then(response => {
          // SnackBar
          this.sbStatus = true;
          this.sbType = "success";
          this.sbText = response.data.message;
          this.loading = false;

          this.dialog = false;

          this.getCategoryFields(this.page);
          // this.$refs.form.reset();
        })
        .catch(error => {
          this.loading = false;
          if (error.response.status == 403) {
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
            if(this.errors.hasError('category_field_slug') ){
                this.slugError = true;
                this.slugErrorMessage = this.errors.first('category_field_slug');
            }
            if(this.errors.hasError('category_field_title') ){
                this.titleError = true;
                this.titleErrorMessage = this.errors.first('category_field_title');
            }
          }
        });
      }else if (this.mainAction === "delete") {

        this.loading = true,
      
        axios.delete('/admin/product/category/field/destroy/'+this.dialogItem.id)
        .then(response => {
          // SnackBar
          this.sbStatus = true;
          this.sbType = "success";
          this.sbText = response.data.message;
          this.loading = false;

          this.dialog = false;

          this.getCategoryFields(this.page);
        })
        .catch(error => {
          this.loading = false;
          this.dialog = false;
          this.sbStatus = true;
          this.sbType = 'error';
          if (error.response && error.response.status == 422) {
            this.errors.setErrors( error.response.data.errors );
            this.sbText = 'Response Error';
          }else{
            this.sbText = 'Error deleting category field';
          }
        });
      }

    },
    toDeleteItem(item) {
      this.dialogItem = Object.assign({}, item);
      this.dialog = true;
      this.mainAction = "delete";
      this.formTitle = 'Confirm Deletion';
      this.toDeleteTitle = this.dialogItem.category_field_title;
      // console.log(this.dialogItem.id);
    },
    close() {
      this.clearAlert();
      this.dialog = false;
    }
  }
};
</script>