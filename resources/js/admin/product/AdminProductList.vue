<template>
   <div>
      <v-row>
         <v-col class="col-12">
            
         <v-data-table
            :headers="headers"
            :items="products"
            :page.sync="page"
            :items-per-page="itemsPerPage"
            hide-default-footer
            class="elevation-1"
         >
            <!-- @page-count="pageCount = $event" -->
            <template v-slot:top>
               <v-toolbar flat color="transparent">
               <v-toolbar-title>Product List</v-toolbar-title>
               <v-spacer></v-spacer>
               <v-btn class="primary" @click="newItem">new</v-btn>
               <!-- <v-dialog v-model="dialog" max-width="500px">
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
               </v-dialog> -->
               </v-toolbar>
            </template>
            <template v-slot:item.title="{ item }">
               <a v-bind:href="'/admin/product/'+item.slug">{{ item.title }}</a>
            </template>
            <template v-slot:item.imagepath="{ item }">
               <v-avatar tile>
                  <v-img :src="'/'+item.imagepath" style="max-width:40px;max-height:40px;"></v-img>
               </v-avatar>
            </template>
            <template v-slot:item.action="{ item }">
               <v-icon small @click="editItem(item)">mdi-pencil</v-icon>
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
      <!-- <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar> -->
   </div>
</template>
<style scoped>
   table td a:hover{
      border-bottom: 1px dotted;
      transition: .1s ease-out;
   }
</style>
<script>
export default {
   data() {
      return {
         // Base URL to be changed in vuex
         baseURL : window.location.origin,

         products : [],
         page: 1,
         pageCount: 1,

         // Data Table
         itemsPerPage: 10,
         page: 1,
         pageCount: 0,
         headers: [
            {
               text: "ID",
               value: "id",
               width: "2%",
               align: "left"
            },
            {
               text: "Image",
               value: "imagepath",
               width: "2%",
               align: "left"
            },
            {
               text: "Title",
               value: "title",
               width: "10%",
               align: "left"
            },
            {
               text: "Price",
               value: "price",
               width: "10%",
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
      }
   },
   methods: {
      onPageChange(){
         this.getProducts(this.page);
      },
      getProducts(p) {
         // Get the data
         axios
         .get("/api/products/?page=" + p)
         .then(response => {
            this.products = response.data.data;
            this.page = response.data.current_page;
            this.pageCount = response.data.last_page;
         })
         .catch(error => {
            console.log("Error: " + error);
         });
      },
      newItem(){

      }
   },
   mounted(){
      this.getProducts(this.page);
   }
}
</script>