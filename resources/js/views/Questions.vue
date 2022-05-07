<template>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 mt-5">
                <new-question-form @newQuestion="newQuestion"></new-question-form>
            </div>
            <div class="col-lg-8 my-5">
                <ul class="list-group list-group-flush">
                    <question-list-item 
                        v-for="q in userQuestions" 
                        :key="q.id"
                        :question="q"
                        @deleteQuestion="deleteQuestion"
                        @goToFullQuestion="goToFullQuestion"
                    ></question-list-item>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import ENV from '../ENV'
import QuestionListItem from '../components/questionComponents/QuestionListItem.vue'
import NewQuestionForm from '../components/questionComponents/NewQuestionForm.vue'
export default {
    data(){
        return {
            question: "",
            userQuestions: [],
        }
    },
    computed:{
        infinitScrollInfo(){
            return {
                userId: this.$store.getters.user.id,
                dataUrl: `${ENV.BASE_URL}questions?user_id=${this.$store.getters.user.id}`,
                nextPageUrl: '',
                PrevPageUrl: '',
            }
        }
    },
    methods:{
        infinitScroll(){
            window.addEventListener("scroll", () => {
                if (document.documentElement.scrollTop + window.innerHeight >= document.documentElement.offsetHeight){
                    if (this.infinitScrollInfo.nextPageUrl) {
                        this.loadMore(this.infinitScrollInfo.nextPageUrl);
                    }
                }
            })
        },
        loadMore(url){
            axios.get(url).then(response => response.data)
            .then(response => {
                this.infinitScrollInfo.nextPageUrl = response.context.data.questions.next_page_url
                this.infinitScrollInfo.PrevPageUrl = response.context.data.questions.prev_page_url
                this.userQuestions.push(...response.context.data.questions.data)
            })
        },
        newQuestion(question){
            console.log(question, "from parent");
            this.userQuestions.unshift(question)
        },
        deleteQuestion(id){
            axios.post(`${ENV.BASE_URL}delete-question/${id}`).then(res => res.data)
            .then( _ => {
                this.userQuestions = this.userQuestions.filter(q => {
                    if (q.id != id)
                    return q
                })
            })
            .catch()
        },
        goToFullQuestion(id){
            this.$router.push(`/full-question/${id}`)
        }
    },
    components:{
        QuestionListItem,
        NewQuestionForm
        // sidebarQuestionContainer
    },
    watch:{
        infinitScrollInfo(newInfinitScrollInfo){
            if (newInfinitScrollInfo.dataUrl !== undefined) {
                this.loadMore(this.infinitScrollInfo.dataUrl)
            }
        }
    },
    mounted(){
        this.infinitScroll()
        if (this.infinitScrollInfo.userId) {
            this.loadMore(this.infinitScrollInfo.dataUrl)
        }
    }
}
</script>