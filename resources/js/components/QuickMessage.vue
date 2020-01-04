<template>

    <v-snackbar
        :color="snackbarColor"
        v-model="snackbar"
    >
        {{ snackbarMessage }}
        <v-btn
        color="white"
        text
        @click="snackbar = false"
        >

        Close
        </v-btn>
    </v-snackbar>
</template>

<script>
    export default {
        props : ['messageType', 'messageText'],
        data () {
            return {
                snackbarColor : 'success',
                snackbar : true,
                snackbarMessage : 'Success'
            }
        },
        mounted () {
            console.log('meh');
        }
    }
</script>