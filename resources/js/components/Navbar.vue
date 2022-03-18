<template>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <router-link to="/" class="navbar-brand" href="#">Navbar</router-link>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" v-if="isAuth">
          <router-link to="/profile" class="nav-link" aria-current="page" href="#">Profile</router-link>
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
import ENV from '../ENV'
import router from '../router'
import {store} from '../store'
export default {
  data(){
    return {
      
    }
  },
  computed:{
    isAuth() {
      return store.getters.auth
    }
  },
  methods:{
    logout(){
      axios.post(`${ENV.BASE_URL}logout`, {}, {
        headers:{
          "Authorization": "Bearer " + localStorage.getItem("authToken")
        }
      })
      .then(response => response.data)
      .then(response => {
        if (response != null && !response.context.error) {
          localStorage.removeItem("authToken")
          store.commit("initUser", null)
          store.commit("checkAuth")
          this.$router.push("/login")
        }
      })

    }
  }
}
</script>