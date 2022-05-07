<template>
    <form @submit.prevent="submit">
        <div class="form-floating">
            <textarea @keydown.enter.prevent @keyup.enter="askQuestion" class="form-control" v-model="question" placeholder="Leave a comment here" id="askQuestionForm"></textarea>
            <label class="text-muted" for="askQuestionForm">Ask a Question</label>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-5">Ask</button>
            <button @click="reset" type="button" class="btn btn-danger ms-4 px-5">Reset</button>
        </div>
    </form>
</template>
<script>
import axios from 'axios'
import ENV from '../../ENV'
export default {
    data(){
        return {
            question: "",
        }
    },
    methods: {
        askQuestion(event){
            event.preventDefault()
            
            axios.post(`${ENV.BASE_URL}ask-question`, {
                question : this.question
            }).then(response => response.data)
            .then(response => {
                console.log(response);
                this.reset()
                this.$emit("newQuestion", response.context.data)
            }).catch( _ => {})
        },
        reset(){
            this.question = ""
        },
    },
}
</script>
<style lang="scss" scoped>
    textarea{
        height: 100px!important;
    }
</style>