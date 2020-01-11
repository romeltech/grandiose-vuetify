<template>
    <div class="text-center">
        <!-- class="transparent" -->
            <!-- flat -->
        <v-card
            :loading="loading">
            <!-- action="./api/user" -->
            <v-form
                class="pa-5"
                @submit.prevent="addproductfield()"
                v-model="valid"
                method="POST"
                ref="form"
                lazy-validation>
                <v-text-field
                    dense
                    :rules="fieldnamerule"
                    v-model="fieldname"
                    autofocus
                    outlined
                    required
                    id="field"
                    type="text"
                    name="field"
                    label="Field"
                    :error="keyError"
                    :error-messages="keyErrorMessage"
                    >
                    <!-- @update:error="(e) => { error = e }" -->
                </v-text-field>
                <v-text-field
                    dense
                    :rules="fieldvaluerule"
                    v-model="fieldvalue"
                    outlined
                    required
                    id="fieldvalue"
                    type="text"
                    name="fieldvalue"
                    label="Value"
                    :error="valueError"
                    :error-messages="valueErrorMessage"
                    >
                     <!-- @update:error="(e) => { error = e }" -->
                </v-text-field>
                    <!-- :disabled="!valid" -->
                <v-btn
                    @click="clearAlert()"
                    width="100%"
                    dense
                    color="primary"
                    class="mb-2"
                    type="submit">
                    Save
                </v-btn>
            </v-form>
        </v-card>
        <snack-bar :snackbar-type="sbType" :snackbar-text="sbText" :snackbar-status="sbStatus"></snack-bar>
    </div>
</template>

<script>

import SnackBar from '../../components/SnackBar.vue';
import ErrorBag from "../../actions/errorBag.js";

export default {
    components: {
      SnackBar
    },
    data () {
        return{
            loading: false,
            errors : new ErrorBag,
            fieldname: '',
            fieldvalue: '',

            // SnackBar
            sbType : '',
            sbText : '',
            sbStatus : false,

            // rules
            valid : true,
            fieldnamerule : [
                value => !!value || 'Required',
                value => (value && value.length < 50)  || 'Max 50 characters',
            ],
            fieldvaluerule :  [
                value => !!value || 'Required',
                value => (value && value.length < 50)  || 'Max 50 characters',
            ],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            // Error Handling
            keyError : false,
            keyErrorMessage : '',
            valueError : false,
            valueErrorMessage : '',
        }
    },
    methods: {
        addproductfield(){
            this.loading = true;
            axios.post('/admin/product/fields/store', {
                pf_key : this.fieldname,
                pf_value : this.fieldvalue
            })
            .then(response => {
                // SnackBar
                this.sbStatus = true;
                this.sbType = 'success';
                this.sbText = response.data.message;

                this.loading = false;
                // this.responseMessage = response.data.message;
                // console.log(response.data.message);
                // console.log('success meh');
                // this.errors.clearAll();
                this.$refs.form.reset();
                // this.keyError = false;
                // this.valueError = false;
            })
            .catch(error => {
                this.loading = false;
                if (error.response && error.response.status == 422) {
                    this.errors.setErrors( error.response.data.errors );
                    // this.responseMessage = this.errors;
                    // console.log(this.responseMessage);
                    // console.log(this.errors.errors.pf_key);
                    // console.log(this.errors.first('pf_key'));
                    // console.log(this.errors.pf_key);
                    // console.log(this.errors);

                    // SnackBar
                    this.sbStatus = true;
                    this.sbType = 'error';
                    this.sbText = 'Error adding product field';

                    // Input error messages
                    if(this.errors.hasError('pf_key') ){
                        this.keyError = true;
                        this.keyErrorMessage = this.errors.first('pf_key');
                    }
                    if(this.errors.hasError('pf_value') ){
                        this.valueError = true;
                        this.valueErrorMessage = this.errors.first('pf_value');
                    }
                }
            });
        },
        clearAlert(){
            this.sbStatus = false; // SnackBar
            this.keyError = false;
            this.keyErrorMessage = '';
            this.valueError = false;
            this.valueErrorMessage = '';
            this.errors.clearAll();
        }
    }
}
</script>