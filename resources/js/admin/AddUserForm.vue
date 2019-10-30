<template>
    <div class="text-center">
        <v-form 
            method="POST"
            action="./api/user"
            ref="form"
            @submit.prevent="addUser()"
            lazy-validation>
            <v-text-field
                v-model="name"
                dense
                autofocus
                outlined
                required
                autocomplete="name" 
                id="name"
                type="text"
                name="name"
                label="Name">
            </v-text-field>

            <v-text-field
                v-model="email"
                dense
                outlined
                required
                autocomplete="email"
                id="email"
                type="email"
                name="email"
                label="E-Mail Address">
            </v-text-field>

            <v-text-field
                v-model="phone"
                dense
                outlined
                required
                autocomplete="phone" 
                id="phone"
                type="text"
                name="phone"
                label="Mobile Number">
            </v-text-field>

                <!-- @input="setSelectedRole" -->
            <v-select
                v-model="role"
                dense
                label="Role"
                outlined
                id="role"
                type="text"
                name="role"
                :items="roles"
                item-value="code"
                item-text="label"

                >
            </v-select>
            <!-- :items="roles.label" -->
            
            <v-text-field
                v-model="password"
                dense
                outlined
                required
                autocomplete="new-password"
                id="password"
                type="password"
                name="password"
                label="Password">
            </v-text-field>

            <v-btn
                dense
                width="100%"
                large
                color="primary"
                class="mb-2"
                type="submit">
                Save
            </v-btn>
        </v-form>
    </div>
</template>

<script>
export default {
    data () {
        return{
            roles : [
                {code : 1, label : 'Super Admin'},  
                {code : 2, label : 'Admin'},  
                {code : 3, label : 'Store Admin'},  
                {code : 4, label : 'Delivery Person'},  
                {code : 5, label : 'Customer'}
            ],
            role : {code : 2, label : 'Admin'},
            name: '',
            email: '',
            phone: '',
            password: '',
        }
    },
    methods: {
        setSelectedRole(){
            
        },
        addUser(){
            axios.post('/api/user', {
                name : this.name,
                email : this.email,
                phone : this.phone,
                password : this.passowrd,
                role : this.role,

            });
            // alert(this.selectedRole)
        // console.log(roles);
        }
    }
  }
</script>