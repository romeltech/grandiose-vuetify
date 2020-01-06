<template>
    <v-snackbar
        :color="sbColor"
        v-model="snackbar"
    >
        {{ sbMessage }}
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
        props : ['snackbarType', 'snackbarText', 'snackbarStatus'],
        data () {
            return {
                snackbar : this.snackbarStatus,
                sbColor : 'primary',
                sbMessage : 'SnackBar Message',
            }
        },
        watch:{
            'snackbarStatus'(){
                this.snackbar = this.snackbarStatus;
            },
            'snackbarType'(){
                this.sbColor = this.snackbarType;
            },
            'snackbarText'(){
                this.sbMessage = this.snackbarText;
            }
        }
    }
</script>