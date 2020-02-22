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
                        <v-btn small color="primary ml-2" @click="update()">Update</v-btn>
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
                                    <v-expansion-panel-header style="min-height:40px;">Caregories</v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <div class="row pt-3">
                                            <v-treeview
                                                dense
                                                selection-type="independent"
                                                selectable
                                                selected-color="primary"
                                                :items="productCategories">
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
    props: ["products"],
    data() {
        return {
            // ui
            loading: false,

            // Base URL to be changed in vuex
            baseURL : window.location.origin,
            productURL : window.location.origin+'/product/'+this.products.slug,

            // Product Data
            title: this.products.title,
            slug: this.products.slug,
            desc: this.products.description,
            img: this.products.imagepath,
            featuredImg: window.location.origin+'/'+this.products.imagepath,

            // Categories
            // loop and check if parent is 0
            // Check if parent = 0,
            // if !0 display then check the child if parent = 0 
            productCategories: [
                {
                id: 1,
                name: 'Applications :',
                children: [
                    { id: 2, name: 'Calendar : app' },
                    { id: 3, name: 'Chrome : app' },
                    { id: 4, name: 'Webstorm : app' },
                ],
                },
                {
                id: 5,
                name: 'Documents :',
                children: [
                    {
                    id: 6,
                    name: 'vuetify :',
                    children: [
                        {
                        id: 7,
                        name: 'src :',
                        children: [
                            { id: 8, name: 'index : ts' },
                            { id: 9, name: 'bootstrap : ts' },
                        ],
                        },
                    ],
                    },
                    {
                    id: 10,
                    name: 'material2 :',
                    children: [
                        {
                        id: 11,
                        name: 'src :',
                        children: [
                            { id: 12, name: 'v-btn : ts' },
                            { id: 13, name: 'v-card : ts' },
                            { id: 14, name: 'v-window : ts' },
                        ],
                        },
                    ],
                    },
                ],
                },
                {
                id: 15,
                name: 'Downloads :',
                children: [
                    { id: 16, name: 'October : pdf' },
                    { id: 17, name: 'November : pdf' },
                    { id: 18, name: 'Tutorial : html' },
                ],
                },
                {
                id: 19,
                name: 'Videos :',
                children: [
                    {
                    id: 20,
                    name: 'Tutorials :',
                    children: [
                        { id: 21, name: 'Basic layouts : mp4' },
                        { id: 22, name: 'Advanced techniques : mp4' },
                        { id: 23, name: 'All about app : dir' },
                    ],
                    },
                    { id: 24, name: 'Intro : mov' },
                    { id: 25, name: 'Conference introduction : avi' },
                ],
                },
            ],
        }
    },
    methods: {
        pageLoading(){
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 2000);
        },
        pageHeight(){
            const height = document.querySelector('header.v-app-bar').offsetHeight + document.querySelector('.secondary-header').offsetHeight;
            document.querySelector('.page-content').style.height = "calc(100vh - "+height+"px - 24px)";
            console.log(height);
        },
        update(){
            this.pageLoading();
        },
        draft(){
            this.pageLoading();
        }
    },
    mounted(){
        this.pageHeight();
    }
}
</script>