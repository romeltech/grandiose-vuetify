<template>
    <div>
        <v-app-bar
        color="deep-purple accent-4"
        dark
        >
        <v-app-bar-nav-icon></v-app-bar-nav-icon>

        <v-toolbar-title>Page title</v-toolbar-title>

        <div class="flex-grow-1"></div>

        <v-btn icon>
            <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        </v-app-bar>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
