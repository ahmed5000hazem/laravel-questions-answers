<template>
    <div @click="clicked" class="offcanvas offcanvas-end sh ow" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex justify-content-center">
            <div class="full-question-container d-flex w-50">
                <div class="question-container w-100">

                    <div class="user">
                        <span class="text-primary">
                            username
                        </span>
                        . asked at 
                        <small>
                            {{this.fullQuestion.question.created_at}}


                            <!-- <div v-for="(item, index) in fullQuestion.question" :key="index">
                                {{Object.keys(fullQuestion.question)}} => {{item}}
                            </div> -->
                            
                        </small>
                    </div>
                    <div class="question border-start border-primary border-2 px-3 py-4 mt-3">
                        question
                    </div>

                </div>

                <div class="answers">
                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            question : this.fullQuestion
        }
    },
    computed:{
        computedQuestionDate(){
            if (this.fullQuestion){
                let d = new Date(this.fullQuestion.question.created_at)
            } else {
                d = null
            }
            return d
        }
    },
    props:["fullQuestion"],
    methods: {
        questionDate(){
            // let d = new Date(this.fullQuestion.context.data.question.created_at)
            
        },
        clicked(){
            console.table(this.fullQuestion.question)
            console.log(this.fullQuestion.question.created_at)
            console.log(this.question.created_at)
        }
    }
}
</script>
<style lang="scss" scoped>
.offcanvas{
    width: 80%;
    .full-question-container{
        .question{
            -webkit-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
            -moz-box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
            box-shadow: 0px 5px 25px -5px rgba(0,0,0,0.7);
        }
    }
}
</style>