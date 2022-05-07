<template>
    <div class="container d-flex w-75 m-auto mt-5 flex-column">
        <div class="question-container w-100">

            <div class="user">
                <span class="text-primary">
                    {{ handeled_user.username}}
                </span>
                <span class="fw-bold">
                    asked at
                </span>
                <small class="text-muted">
                    {{question_date}}
                </small>
            </div>
            <div class="question border-start border-primary border-2 px-3 py-4 mt-3">
                {{question.question}}
            </div>
            
            <form @submit.prevent="answerQuestion" class="answer-question-form">
                <div class="mb-3 position-relative">
                    <input type="text" class="form-control mt-3 pe-5" id="questionAnswer" aria-describedby="questionAnswer" placeholder="answer the question" v-model="newAnswer">
                    <button type="submit" class="position-absolute rounded-circle border-primary top-50 end-0 translate-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                    </button>
                </div>
            </form>
            
        </div>

        <div class="answers">
            <div class="answer fw-bold px-4 py-3 w-100 m-auto mt-4 border-bottom border-danger" v-for="(answer, index) in answers" :key="index">
                <small class="text-muted">
                    {{ handelDate(answer.created_at) }}
                </small>
                <div>
                    {{answer.answer}}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import ENV from '../ENV'

export default {
    data(){
        return {
            question: {},
            user: {},
            newAnswer: "",
            answers:[],
            handeled_user: {},
            question_raw_created_at: null,
            question_date : null,
            id: this.$route.params.id
        }
    },
    methods:{
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
        },
        getQuestionDate(){
            this.question_date = this.handelDate(this.created_at)
            // console.log(`${day} ${d.getDate()}, ${month}, ${d.getFullYear()} AT ${ hours } ${duration}`);
        },
        answerQuestion(){
            axios.post(`${ENV.BASE_URL}answer-question/${this.$route.params.id}`, {
                answer: this.newAnswer
            }).then(response => response.data)
            .then(response => {
                if (!response.context.error) { 
                    this.answers.unshift(response.context.data.answer)
                    this.newAnswer = ""
                } 
            })
        },
        handelUser(){
            let username = this.user.email.split("@")
            username = username[0]
            let user = {
                username: username
            }
            this.handeled_user = user
        }
    },
    mounted(){
        axios.get(`${ENV.BASE_URL}questions/${this.id}`).then(response => response.data)
        .then(response => {
            this.question = response.context.data.question
            this.user = response.context.data.user
            this.answers = response.context.data.answers
            this.created_at = this.question.created_at
            this.getQuestionDate()
            this.handelUser()
        })
    }
}
</script>
<style lang="scss" scoped>
    .question{
        -webkit-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
        -moz-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
        box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
    }
</style>