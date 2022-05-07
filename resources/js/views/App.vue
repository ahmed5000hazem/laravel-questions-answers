<template>
    <navbar-component></navbar-component>
    <div class="container">
        <router-view></router-view>
    </div>
</template>
<script>

import NavbarComponent from '../components/Navbar'
export default {
    components: {
        NavbarComponent
    },
    methods: {
        isAuth(){
            this.$store.commit("checkAuth")
        }
    },
    beforeMount(){
        // if(this.$store.getters.auth){
            //     this.$store.dispatch("getAuthUser")
        // }
        this.isAuth()
        axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("authToken")
        if(this.$store.getters.auth){
            this.$store.dispatch("getAuthUser")
            
        }
    },
    created(){
        axios.interceptors.response.use(function (response) {
            if (response.status === 401){
                this.$router.push("/login")
            }
            return response;
        }, function (error) {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            // Do something with response error
            return Promise.reject(error);
        });
    }
}
</script>