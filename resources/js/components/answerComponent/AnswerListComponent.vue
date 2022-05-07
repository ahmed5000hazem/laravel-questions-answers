<template>
    <div class="answer fw-bold px-4 py-3 w-100 m-auto mt-4 border-bottom border-danger">
        <small class="text-muted">
            {{ handelDate(answer.created_at) }}
        </small>
        <small class="mb-2 d-block">
            <router-link class="border-start border-primary border-2 px-1 text-decoration-none text-dark" :to="{name:'fullQuestion', params: {id:answer.id} }">
                {{answer.question}}
            </router-link>
        </small>
        <div class="text-primary">
            {{answer.answer}}
        </div>
    </div>
</template>
<script>
export default {
    props:["answer"],
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
}
</script>
<style lang="scss">

</style>