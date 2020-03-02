<template>
    <div class="row" style="position:relative;">
        <v-overlay :value="loading" color="#FFF">
            <v-progress-circular indeterminate color="primary" width="3" size="32"></v-progress-circular>
        </v-overlay>
        <v-card flat class="grey lighten-4" style="width:100%;">
            <form action="" class="mt-n3">
                <div class="secondary-header" style="border-bottom:1px solid #ddd;">
                    <v-toolbar dense flat class="grey lighten-4">
                        <v-toolbar-title>Edit Product</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn small text class="info--text" @click="draft()">Save as Draft</v-btn>
                        <v-btn small class="ml-2" :href="productURL" target="_blank">Preview</v-btn>
                        <v-btn small color="primary ml-2" @click="submit()">Update</v-btn>
                    </v-toolbar>
                </div>
                <div class="page-content col-12 pb-0 px-3" style="overflow-y:scroll;">
                    <div class="d-flex">
                        <div class="col-md-8 col-12">
                            <v-card class="mx-auto">
                                <v-card-text>
                                    <v-text-field
                                        label="title"
                                        name="title"
                                        outlined
                                        dense
                                        v-model="title"
                                    ></v-text-field>
                                    <v-text-field
                                        label="slug"
                                        name="slug"
                                        outlined
                                        dense
                                        v-model="slug"
                                    ></v-text-field>
                                    <v-textarea
                                        outlined
                                        name="description"
                                        label="description"
                                        v-model="desc"
                                    ></v-textarea>
                                </v-card-text>
                            </v-card>
                        </div>
                        <div class="col-md-4 col-12">

                            <v-expansion-panels accordion multiple focusable>
                                <v-expansion-panel>
                                    <v-expansion-panel-header style="min-height:40px;" @click="loadProductCategories()">Caregories</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="row pt-3">
                                            <v-progress-circular v-if="treeLoaded == false" class="mx-auto" indeterminate color="primary" :width="2" :size="20"></v-progress-circular>
                                            <v-treeview
                                                v-model="selection"
                                                v-if="treeLoaded == true"
                                                selection-type="independent"
                                                dense
                                                selectable
                                                selected-color="primary"
                                                :items="productCategoriesTree">
                                                <template slot="label" slot-scope="props">
                                                    <span>
                                                        {{props.item.id}} - {{props.item.title}}
                                                    </span>
                                                </template>
                                            </v-treeview>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header style="min-height:40px;">Featured Image</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="pt-3">
                                            <v-img :src="featuredImg" aspect-ratio="2" contain></v-img>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                                <v-expansion-panel>
                                    <v-expansion-panel-header style="min-height:40px;">Gallery</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="pt-3">
                                            <div class="row">
                                                <div style="border:1px solid #eee;" class="col-4" v-for="n in 5" :key="n">
                                                    <v-img :src="featuredImg" aspect-ratio="2" contain></v-img>
                                                </div>
                                            </div>
                                        </div>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </div>
                    </div>
                </div><!-- page-content -->
            </form>
        </v-card>
    </div>


</template>

<script>
export default {
    props: ["product"],
    data() {
        return {
            // ui
            loading: false,

            // Base URL to be changed in vuex
            baseURL : window.location.origin,
            productURL : window.location.origin+'/product/'+this.product.slug,

            // Product Data
            id: this.product.id,
            title: this.product.title,
            slug: this.product.slug,
            desc: this.product.description,
            img: this.product.imagepath,
            featuredImg: window.location.origin+'/'+this.product.imagepath,

            // Product Categories Tree
            productCategoriesTree: [],
            treeLoaded: false,
            selection: [],
        }
    },
    watch: {
    //   selection : function(val){
    //    console.log(val);
    //   }
    },
    methods: {
        pageLoading(){
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 2000);
        },
        pageHeight(){
            // Set page height
            const height = document.querySelector('header.v-app-bar').offsetHeight + document.querySelector('.secondary-header').offsetHeight;
            document.querySelector('.page-content').style.height = "calc(100vh - "+height+"px - 24px)";
        },
        loadProductCategories(){
            this.getProductCategoriesTree();    
        },
        getProductCategoriesTree () {
            // Get Product Categories Tree
            axios.get('/api/product/category/tree')
            .then(response => {
                this.productCategoriesTree = response.data;
                this.treeLoaded = true;
            })
            .catch(error => {
                console.log(error.response);
                console.log('Error fetching data');
            });
        },
        submit(){
            console.log(this.selection);
            axios.post('/admin/product/update', {
                id : this.id,
                categories : this.selection,
            })
            .then(response => {
                console.log(response.data)
                // this.successUI(response.data.message);
            })
            .catch(error => {
                this.loading = false;
            });
        },
        update(){
            this.pageLoading();
            console.log(this.selection)
        },
        draft(){
            this.pageLoading();
        }
    },
    mounted(){
        this.pageHeight();
        console.log(this.selection);
    }
}
</script>