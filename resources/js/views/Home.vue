<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mt-5">
                <new-question-form></new-question-form>
            </div>
            <div class="col-lg-8 my-5">
                <div class="posts">
                    <div class="post-question">
                        <ul class="list-group list-group-flush">
                            <question-list-item 
                                v-for="q in questions" 
                                :key="q.id"
                                :question="q"
                            ></question-list-item>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import NewQuestionForm from '../components/questionComponents/NewQuestionForm.vue'
import QuestionListItem from '../components/questionComponents/QuestionListItem.vue'
import ENV from '../ENV'
export default {
    data(){
        return {
            infinitScrollInfo: {
                dataUrl: `${ENV.BASE_URL}questions`,
                nextPageUrl: '',
                PrevPageUrl: '',
            },
            questions: []
        }
    },
    methods: {
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
                this.questions.push(...response.context.data.questions.data)
            })
        }
    },
    mounted(){
        this.infinitScroll()
        this.loadMore(this.infinitScrollInfo.dataUrl)
    },
    components:{
        NewQuestionForm,
        QuestionListItem
    },
}
</script>
<style lang="scss" scoped>

</style>