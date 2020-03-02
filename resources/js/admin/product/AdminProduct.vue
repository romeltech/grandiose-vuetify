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
                        <v-btn small color="primary" class="ml-2" :disabled="!valid" @click="update()">Update</v-btn>
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
                                                open-on-click
                                                dense
                                                selectable
                                                selected-color="primary"
                                                :items="productCategoriesTree"
                                                style="width:100%"
                                                @input="getParents()"
                                                >
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
    props: ["product","categories"],
    data() {
        return {
            // ui
            loading: false,
            valid: true,
            // Snack Bar
            sbStatus : false,
            sbType : '',
            sbText : '',

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
            productCategories: this.categories,

            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),

            // Product Categories Tree
            allCategories: [],
            productCategoriesTree: [],
            treeLoaded: false,
            selection: [],
        }
    },
    methods: {
        successUI(msg){
            this.loading = false;
            this.valid = true;
            // SnackBar
            setTimeout(() => {
                this.sbStatus = true;
                this.sbType = 'success';
                this.sbText = msg;
            }, 100);
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
                this.selection = this.categories.map(function (cat) {
                    return cat.id
                });
                this.treeLoaded = true;
                // console.log(this.productCategoriesTree);
            })
            .catch(error => {
                console.log(error.response);
                console.log('Error fetching data');
            });
        },
        getProductCategoriesList () {
            axios.get('/api/product/category/list')
            .then(response => {
                this.allCategories = response.data;
            })
            .catch(error => {
                console.log(error.response);
                console.log('error');
            });
        },
        update(){
            this.valid = false;
            this.loading = true;
            let productData = [];
            if(this.treeLoaded == true){
                productData = {
                    id : this.id,
                    title : this.title,
                    slug : this.slug,
                    description : this.desc,
                    categories : this.selection,
                };                
            }else{
                productData = {
                    id : this.id,
                    title : this.title,
                    slug : this.slug,
                    description : this.desc
                };
            }
            axios.post('/admin/product/update', productData)
            .then(response => {
                this.successUI(response.data.message);
                console.log(response.data);
            })
            .catch(error => {
                this.loading = false;
            });
        },
        getParents(){

            console.log(this.selection);
        },
        draft(){
            
            // // this.loading = true;
            // var parent = _.filter(this.productCategoriesTree, function(r){
            //     for(var i=0; i<r.length; i++){
            //         console.log(r[i].id);
            //         if(r[i].id === allChildPosts[index].id){
            //             return r.id;
            //         }
            //     }
            // });
            // console.log(this.productCategoriesTree);

        }
    },
    mounted(){
        this.pageHeight();
        this.getProductCategoriesList();
    }
}
</script>