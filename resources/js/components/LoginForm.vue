<template>
   <v-row class="justify-center">
        <v-col cols="12" sm="6" md="4">
            <v-card id="loginform">
                <v-card-title>Login</v-card-title>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data: () => ({
            valid: true,
            email: '',
            emailrules: [
                value => !!value || 'Required',
                value => /.+@.+\..+/.test(value) || 'E-mail must be valid'
            ],
            password: '',
            passwordrules: [
                value => !!value || 'Required',
                value => (value && value.length > 8) || 'Password must be atleast 8 characters',
            ],
        }),
        methods: {
            validate () {
                if (this.$refs.form.validate()) {
                    this.snackbar = true
                }
            }
        }
    }
</script>
