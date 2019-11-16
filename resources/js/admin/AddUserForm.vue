<template>
    <div class="text-center">
        <v-card
            flat
            class="transparent"
            :loading="loading">
                <!-- action="./api/user" -->
            <v-form
                v-model="valid"
                method="POST"
                ref="form"
                @submit.prevent="addUser()"
                lazy-validation>

                <v-text-field
                    :rules="nameRules"
                    v-model="name"
                    autofocus
                    outlined
                    required
                    autocomplete="name" 
                    id="name"
                    type="text"
                    name="name"
                    label="Name"
                    >
                </v-text-field>

                <v-text-field
                    :rules="emailRules"
                    v-model="email"
                    outlined
                    required
                    autocomplete="email"
                    id="email"
                    type="email"
                    name="email"
                    label="E-Mail Address">
                </v-text-field>

                <v-select
                    v-model="role"
                    label="Role"
                    outlined
                    id="role"
                    type="text"
                    name="role"
                    :items="roles"
                    item-value="val"
                    item-text="label"
                    >
                </v-select>
                
                <v-text-field
                    :rules="nameRules"
                    v-model="password"
                    required
                    outlined
                    autocomplete="new-password"
                    id="password"
                    type="password"
                    name="password"
                    label="Password">
                </v-text-field>

                <v-btn
                    :disabled="!valid"
                    @click="clearAlert()"
                    width="100%"
                    large
                    color="primary"
                    class="mb-2"
                    type="submit">
                    Save
                </v-btn>

                <v-alert
                    flat
                    v-model="errorAlert"
                    dismissible
                    color="red"
                    border="left"
                    elevation="2"
                    colored-border
                    icon="mdi-alert-circle"
                    class="text-left transparent mt-5"
                    >
                    <div>{{ errors.first('name') }}</div>
                    <div>{{ errors.first('email') }}</div>
                    <div>{{ errors.first('phone') }}</div>
                    <div>{{ errors.first('role') }}</div>
                    <div>{{ errors.first('password') }}</div>
                    <!-- <div class="invalid-feedback" v-if="errors.has('email')" >{{ errors.first('email') }}</div> -->
                </v-alert>

                <v-alert
                    flat
                    v-model="successAlert"
                    dismissible
                    color="success"
                    border="left"
                    elevation="2"
                    colored-border
                    icon="mdi-alert-circle"
                    class="text-left transparent mt-5"
                    >
                    <div>{{successMessage}}</div>
                    <!-- <div>{{ message }}</div> -->
                    <!-- <div class="invalid-feedback" v-if="errors.has('email')" >{{ errors.first('email') }}</div> -->
                </v-alert>
            </v-form>
        </v-card>
    </div>
</template>

<script>

import ErrorBag from "../actions/errorBag.js";

export default {
    // props : ['formErrors'],
    data () {
        return{
            successMessage : '',
            successAlert: false,
            errorAlert: false,
            loading: false,
            errors : new ErrorBag,
            roles : [
                {val : 1, label : 'Super Admin'},  
                {val : 2, label : 'Admin'},  
                {val : 3, label : 'Store Admin'},  
                {val : 4, label : 'Delivery Person'},  
                {val : 5, label : 'Customer'}
            ],
            role : 2,
            name: '',
            email: '',
            password: '',

            //rules
            valid : true,
            emailRules : [
                value => !!value || 'Required',
                value => /.+@.+\..+/.test(value) || 'E-mail must be valid'
            ],
            nameRules :  [
                value => !!value || 'Required',
                value => (value && value.length < 255)  || 'Max 255 characters',
            ],
            // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

        }
    },
    methods: {
        addUser(){
            this.loading = true;
            // axios.post('/user/store', {
            axios.post('/admin/user/store', {
                name : this.name,
                email : this.email,
                phone : this.phone,
                password : this.password,
                role : this.role,
            })
            .then(response => {
                this.successMessage = response.data.message;
                this.loading = false;
                this.successAlert = true;
                // setTimeout(() => { this.successAlert = false; }, 3000);
                // console.log('success meh');
            })
            .catch(error => {
                this.loading = false;
                this.errorAlert = true;
                if (error.response && error.response.status == 422) {
                    this.errors.setErrors( error.response.data.errors );
                    console.log(this.errors);
                }
            });
        },
        clearAlert(){
            this.successAlert = false;
            this.errorAlert = false;
        }
    }
  }
</script>