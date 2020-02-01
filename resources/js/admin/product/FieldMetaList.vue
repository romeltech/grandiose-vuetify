<template>
    <div>
        <v-row>
             <v-col class="col-12 col-md-8">
                <v-data-table
                    :headers="headers"
                    :items="fieldMetas"
                    :page.sync="page"
                    :items-per-page="itemsPerPage"
                    hide-default-footer
                    class="elevation-1"
                    @page-count="pageCount = $event"
                    >
                       <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>{{tableTitle}}</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn class="primary" >new</v-btn>
                                <!-- @click="submit" -->

                            </v-toolbar>
                        </template>
                    
                    </v-data-table>
                    <v-pagination v-model="page" :length="pageCount" class="mt-3"></v-pagination>
             </v-col>
        </v-row>
    </div>
</template>

<script>
  export default {
    props : ['productField' ,'fieldMeta'],
    data () {
      return {
        // Form
        valid : false,
        metaTitle : '',
        metaTitleRules : '',
        
        // Product Fields
        pf : this.productField,

        tableTitle : this.productField.pf_value,
        itemsPerPage : 10,
        page: 1,
        pageCount: 0,
        headers: [
          { text: 'Meta Title', value: 'name', width: '40%', align: 'left' },
          { text: 'Slug', value: 'calories', width: '40%', align: 'left' },
          { text: 'Action', value: 'fat', width: '20%', align: 'right' },
        ],
        fieldMetas: [],
      }
    },
    mounted (){
        console.log(this.fieldMeta);
    },
  }
</script>