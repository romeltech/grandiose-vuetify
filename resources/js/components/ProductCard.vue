<template>
  <v-row class="justify-center">
    <v-card v-for="product in products" v-bind:key="product.id"
      :loading="loading" class="product-card my-5">
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
          color="green"
          @click="reserve"
        >
          Add
        </v-btn>
          <v-select
          :items="quantity"
          label="1"
          solo
          flat
          class="product-qty"></v-select>
      </v-card-actions>
    </v-card>
  </v-row>
</template>

<script>
  export default {
    props: ['products'],
    mounted () {
        // Do something useful with the data in the template
        console.log(this.products);
    },
    // components:{
    //   products
    // },
    // data() {
    //   return {
    //     prod: this.products
    //   }
    // },
    data: () => ({
      loading: false,
      selection: 1,
      quantity: [1,2,3,4,5,6,7,8,9],
    }),
    methods: {
      reserve () {
        this.loading = true

        setTimeout(() => (this.loading = false), 2000)
      },
    },
  }
</script>