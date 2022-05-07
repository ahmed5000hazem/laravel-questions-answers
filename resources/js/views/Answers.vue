<template>
    <div class="container d-flex w-75 m-auto mt-5 flex-column">

        <div class="answers">
            <answer-list-component 
                v-for="(answer, index) in answers" :key="index"
                :answer="answer"
            />
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import ENV from '../ENV'
import AnswerListComponent from '../components/answerComponent/AnswerListComponent'
export default {
    data(){
        return {
            answers:[]
        }
    },
    components:{
        AnswerListComponent
    },
    computed:{
        user(){
            return this.$store.getters.user
        },
        handeled_user(){
            let user = {
                username: ""
            }
            if (this.$store.getters.user.email !== undefined){
                let username = this.user.email.split("@")
                username = username[0]
                user.username = username
                return user
            } else {
                return {}
            }
        }
    },
    methods: {
        handelDate(date){
            let d = new Date(date)
            
            const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            let month = months[d.getMonth()];

            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            let day = days[d.getDay()];
            let duration
            let hours
            if (d.getHours() >= 12) {
                duration = "PM"
                hours = d.getHours() - 12
                if (d.getHours() == 12){
                    hours = 12
                }
            } else {
                duration = "AM"
                hours = d.getHours()
                if (d.getHours() == 0){
                    hours = 12
                }
            }
            return `${day} ${d.getDate()}, ${month}, ${d.getFullYear()} AT ${ hours } ${duration}`
        }
    },
    watch: {
        user(newUser){
            if (newUser.email !== undefined){
                axios.get(`${ENV.BASE_URL}answers/user/${newUser.id}`).then(response => response.data)
                .then(response => {
                    this.answers = response.context.data
                })
            }
        }
    },
    mounted() {
        if (this.user.email !== undefined){
            axios.get(`${ENV.BASE_URL}answers/user/${this.user.id}`).then(response => response.data)
            .then(response => {
                this.answers = response.context.data
            })
        }
    },
}
</script>
<style lang="scss" scoped>
.question{
    -webkit-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
    -moz-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
    box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
}
</style>