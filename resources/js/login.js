import 'babel-polyfill'
import Vue from 'vue'
import Vuetify from 'vuetify' // path to vuetify export

Vue.use(Vuetify)
// Vue.component('login-form', require('./components/LoginForm.vue').default);

const loginscript = new Vue({
    el: '#g-login',
    vuetify: new Vuetify({
        theme: {
            themes: {
                light: {
                    primary: '#1D1D1B',
                    secondary: '#E1341E',
                    accent: '#82B1FF',
                    error: '#FF5252',
                    info: '#2196F3',
                    success: '#4CAF50',
                    warning: '#FFC107',
                
                    // Grandiose Colors
                    red: '#D42427',
                    text: '#1D1D1B'
                }
            }
        },
    }),
    data () {
        return {
            //login
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
        }
    },
    methods: {
        validate () {
            if (this.$refs.form.validate()) {
            this.snackbar = true
            }
        }
    }
});

export default loginscript;