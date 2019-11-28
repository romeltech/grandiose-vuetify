<template>
    <div>
        <v-card class="elevation-0" min-height="450px">
            <v-row class="justify-center">
                <v-card 
                    v-for="product in products" v-bind:key="product.id"
                    :loading="loading" 
                    outlined
                    tile
                    class="product-card my-0 mx-0">
                    <v-img src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                    <v-card-title>{{product.title}}</v-card-title>
                    <v-card-text>
                        <div class="my-1 subtitle-1 black--text">
                        {{product.price}} AED
                        </div>
                        <div class="product-desc">{{product.description}}</div>
                    </v-card-text>
                    <v-divider class="mx-4"></v-divider>
                    <v-card-actions class="product-action">
                        <v-btn
                            color="primary"
                            @click="addToCart"
                        >
                        Add
                        </v-btn>
                        <v-select
                            label="1"
                            solo
                            flat
                            class="product-qty">
                        </v-select>
                    </v-card-actions>
                </v-card>   
            </v-row>
            <v-row class="justify-center my-5">
                <div class="text-center">
                    <v-pagination
                        v-model="currentpage"
                        :length="lastpage"
                        :total-visible="7"
                        @input="onPageChange"
                    ></v-pagination>
                </div>
            </v-row>
            <v-overlay
                :absolute="true"
                :value="overlay"
                color="#FFFFFF"
                opacity=".9"
                >
                <v-progress-circular
                :width="3"
                color="primary"
                indeterminate
                ></v-progress-circular>
            </v-overlay>
        </v-card>


    </div>
</template>

<script>
  export default {
    // props : ['productData'],
    data () {
        return {
            loading: false,
            products : [],
            currentpage : 1,
            lastpage: null,

            overlay: true,
        }
    },
    methods: {
        addToCart () {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },
        getProducts (){
            this.overlay = true;
            axios.get('api/products/?page='+ this.currentpage)
            .then(response => {
                setTimeout(() => (
                    this.products = response.data.data,
                    this.currentpage = response.data.current_page,
                    this.lastpage = response.data.last_page,
                    this.overlay = false                    
                ), 1000)
            })
            .catch(error => {
                console.log(error.response);
            });
        },
        onPageChange (){
            this.getProducts()            
        }
    },
    mounted (){
        this.getProducts();
    }
  }
</script>