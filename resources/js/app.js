require('./bootstrap');

import * as Vue from 'vue'
import router from './router'
import AppComponent from './views/App'
window.axios.defaults.withCredentials = true
const App = Vue.createApp({
    components:{
        AppComponent
    }
});

App.use(router)
App.mount('#app')