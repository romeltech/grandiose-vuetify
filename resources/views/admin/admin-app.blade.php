<v-app-bar app clipped-left color="primary">
    <v-app-bar-nav-icon @click="drawer = !drawer" class="white--text"></v-app-bar-nav-icon>
    <span class="title ml-3 mr-5 white--text">Grandiose Admin Panel</span>
    <v-spacer></v-spacer>
    <user-nav-icon
      :auth-user="{{ Auth::user() }}">
    </user-nav-icon>
</v-app-bar>

<v-navigation-drawer
v-model="drawer"
app
clipped
color="grey lighten-4"
>
<v-list
  class="grey lighten-4"
>

<v-row align="center">
  <v-col cols="6">
    <v-subheader>Admin</v-subheader>
  </v-col>
  {{-- <v-col cols="6" class="text-right">
    <v-btn small text>edit</v-btn>
  </v-col> --}}
</v-row>
{{-- List Group --}}
<v-list-group>
  <template v-slot:activator>
    <v-list-item-icon>
      <v-icon>mdi-basket</v-icon>
    </v-list-item-icon>
    <v-list-item-title class="grey--text">Products</v-list-item-title>
  </template>
  <v-list dense class="grey lighten-3">
    <v-list-item  @click="">
      <v-list-item-action>
        <v-icon small>mdi-format-list-bulleted</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">Product List</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item @click="">
      <v-list-item-action>
        <v-icon small>mdi-plus</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">Add Product</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item href="{{ route('admin.p.fields') }}">
      <v-list-item-action>
        <v-icon small>mdi-layers-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">Product Fields</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item @click="">
      <v-list-item-action>
        <v-icon small>mdi-upload</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">Import Products</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>
</v-list-group>


<v-divider dark></v-divider>


{{-- Label  --}}
{{-- auth()->user()->id --}}
<v-row align="center">
  <v-col cols="6">
    <v-subheader>Administrator</v-subheader>
  </v-col>
</v-row>

<v-list-group>

  <template v-slot:activator>
    <v-list-item-icon>
      <v-icon>mdi-account-multiple</v-icon>
    </v-list-item-icon>
    <v-list-item-title class="grey--text">Users</v-list-item-title>
  </template>

  <v-list dense class="grey lighten-3">
    <v-list-item href="{{ route('admin.users') }}">
      <v-list-item-action>
        <v-icon small>mdi-account-multiple-outline</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">{{ __('User List') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    <v-list-item href="{{ route('admin.adduser' ) }}">
      <v-list-item-action>
        <v-icon small>mdi-account-plus</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">{{ __('Add User') }}</v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </v-list>

</v-list-group>

{{-- <v-list-item href="{{ route('admin.settings', auth()->user()->id ) }}"> --}}
<v-list-item href="{{ route('admin.settings') }}">
  <v-list-item-action>
    <v-icon>mdi-settings</v-icon>
  </v-list-item-action>
  <v-list-item-content>
    <v-list-item-title class="grey--text">{{ __('Settings') }}</v-list-item-title>
  </v-list-item-content>
</v-list-item>

</v-list>

</v-navigation-drawer>

<v-content style="height:100%">
  <v-container style="height:100%" fluid class="grey lighten-4">
    <v-col>
      @yield('admin-content')
    </v-col>
  </v-container>
</v-content>
