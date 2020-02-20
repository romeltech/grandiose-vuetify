<template>
    <div class="row">
        <div class="col-md-8 col-12">
            <v-card class="mx-auto">
                <v-card-text>
                <div>Edit</div>
                <p class="display-1 text--primary">
                    {{title}}
                </p>
                <p>{{slug}}</p>
                <div class="text--primary">
                    well meaning and kindly.<br>
                    "a benevolent smile"
                </div>
                </v-card-text>
                <v-card-actions>
                <v-btn
                    text
                    color="deep-purple accent-4"
                >
                    Learn More
                </v-btn>
                </v-card-actions>
            </v-card>
        </div>
        <div class="col-md-4 col-12">
            <v-card class="mx-auto">
                <v-card-text>
                <div>Word of the Day</div>
                <p class="display-1 text--primary">
                    be•nev•o•lent
                </p>
                <p>adjective</p>
                <div class="text--primary">
                    well meaning and kindly.<br>
                    "a benevolent smile"
                </div>
                </v-card-text>
                <v-card-actions>
                <v-btn
                    text
                    color="deep-purple accent-4"
                >
                    Learn More
                </v-btn>
                </v-card-actions>
            </v-card>
        </div>
    </div>


</template>

<script>
export default {
    props: ["products"],
    data() {
        return {
            // Base URL to be changed in vuex
            baseURL : window.location.origin,

            // Product Data
            title: this.products.title,
            slug: this.products.slug,
        }
    },
    methods: {
    },
    mounted(){
        console.log(this.products);
    }
}
</script>