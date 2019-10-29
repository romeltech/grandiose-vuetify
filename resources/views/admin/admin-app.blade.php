<v-app-bar app clipped-left color="amber">
    <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
    <span class="title ml-3 mr-5">Grandiose Admin Panel</span>
    <v-spacer></v-spacer>
</v-app-bar>

<v-navigation-drawer
v-model="drawer"
app
clipped
color="grey lighten-4"
>
<v-list
  dense
  class="grey lighten-4"
>
  <template v-for="(item, i) in items">
    <v-row
      v-if="item.heading"
      :key="i"
      align="center"
    >
      <v-col cols="6">
        <v-subheader v-if="item.heading">
          {{-- {{ item.heading }} --}}
          omel
        </v-subheader>
      </v-col>
      <v-col
        cols="6"
        class="text-right"
      >
        <v-btn
          small
          text
        >edit</v-btn>
      </v-col>
    </v-row>
    <v-divider
      v-else-if="item.divider"
      :key="i"
      dark
      class="my-4"
    ></v-divider>
    <v-list-item
      v-else
      :key="i"
      @click=""
    >
      <v-list-item-action>
            {{-- {{ item.icon }} --}}
        <v-icon>mdi-user</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title class="grey--text">
          {{-- {{ item.text }} --}}
          This is user
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
  </template>
</v-list>
</v-navigation-drawer>

<v-content style="height:100%">
<v-container
  fluid
  class="grey lighten-4 fill-height" 
>
  <v-row
    justify="center"
    align="center" 
  >
    <v-col class="shrink" >
      <v-tooltip right>
        <template v-slot:activator="{ on }">
          <v-btn
            {{-- :href="source" --}}
            icon
            large
            target="_blank"
            v-on="on"
          >
            <v-icon large>mdi-code-tags</v-icon>
          </v-btn>
        </template>
        <span>Source</span>
      </v-tooltip>
      <v-tooltip right>
        <template v-slot:activator="{ on }">
          <v-btn
            icon
            large
            href="https://codepen.io/johnjleider/pen/zgxbYO"
            target="_blank"
            v-on="on"
          >
            <v-icon large>mdi-codepen</v-icon>
          </v-btn>
        </template>
        <span>Codepen</span>
      </v-tooltip>
    </v-col>
  </v-row>
</v-container>
</v-content>