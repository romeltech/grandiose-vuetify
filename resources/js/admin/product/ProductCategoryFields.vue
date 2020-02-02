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
              <v-btn class="primary" >new</v-btn>
              <!-- @click="submit" -->
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
  </div>
</template>

<script>
  export default {
    props : ['productCategory'],
    data () {
      return {
        // Form
        valid : false,
        metaTitle : '',
        metaTitleRules : '',
        
        // Product Category objecy
        pCategory : this.productCategory,

        // Data Table
        categoryFields : [],
        tableTitle :'',
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
      getCategoryFields(i){
        // Get the data 
        axios.get('/api/product/category/fields/'+this.pCategory.id+'?page='+i)
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
      editItem(itemToEdit){
        console.log(itemToEdit);
      },
      deleteItem(itemToDelete){
        console.log(itemToDelete);
      }
    }
  }
</script>