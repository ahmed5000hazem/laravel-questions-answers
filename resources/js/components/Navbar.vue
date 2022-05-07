<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <router-link to="/" class="navbar-brand" href="#">Q A</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" v-if="isAuth">
          <router-link :to="'/questions/'" class="nav-link" aria-current="page" href="#">Questions</router-link>
        </li>
        <li class="nav-item" v-if="isAuth">
          <router-link :to="'/answers/'" class="nav-link" aria-current="page" href="#">Answers</router-link>
        </li>
        
        <li class="nav-item" v-if="!isAuth">
          <router-link to="/login" class="nav-link" href="#">Login</router-link>
        </li>
        <li class="nav-item" v-if="!isAuth">
          <router-link to="/sign-up" class="nav-link" href="#">Sign Up</router-link>
        </li>
        <li class="nav-item" v-if="isAuth">
          <a @click.prevent="logout" class="nav-link" href="#">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>
<script>
import {store} from '../store'
export default {
  data(){
    return {
      
    }
  },
  computed:{
    isAuth() {
      return store.getters.auth
    },
    user(){
      return this.$store.getters.user
    }
  },
  methods:{
    logout(){
      store.dispatch("logout")
    }
  }
}
</script>