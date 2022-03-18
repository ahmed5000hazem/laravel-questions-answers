<template>
    <div>
        {{user}}
    </div>
</template>
<script>
import axios from 'axios'
import ENV from '../ENV'
export default {
    data(){
        return {
            user:{}
        }
    },
    methods:{
        loadUserData(){
            axios.get(`${ENV.BASE_URL}user`, {
                headers:{
                    "Authorization": "Bearer " + localStorage.getItem("authToken")
                }
            })
            .then(response => response.data)
            .then(response => {
                this.user = response
            })
        }
    },
    mounted(){
        this.loadUserData()
    }
}
</script>