<template>
    <div>
        <v-row class="justify-center">
            <template>
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
            </template>
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
        }
    },
    methods: {
        addToCart () {
            this.loading = true
            setTimeout(() => (this.loading = false), 2000)
        },
        getProducts (){
            axios.get('api/products/?page='+ this.currentpage)
            .then(response => {
                this.products = response.data.data;
                this.currentpage = response.data.current_page;
                this.lastpage = response.data.last_page;
            })
            .catch(error => {
                console.log(error.response);
            });
        },
        onPageChange (){
            console.log(this);
            this.getProducts();
        }
    },
    mounted (){
        this.getProducts();
    }
  }
</script>