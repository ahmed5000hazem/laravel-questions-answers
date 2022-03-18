require('./bootstrap');

import * as Vue from 'vue'
import router from './router'
import AppComponent from './views/App'

import {store} from './store/index'
import axios from 'axios';
import ENV from './ENV';

const App = Vue.createApp({
    components:{
        AppComponent
    },
    methods: {
        isAuth(){
            store.commit("checkAuth")
        }
    },
    mounted(){
        this.isAuth()
    }
});
App.use(router)
App.use(store)
App.mount('#app')