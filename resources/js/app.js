require('./bootstrap');

import * as Vue from 'vue'
import router from './router'
import AppComponent from './views/App'

import {store} from './store/index'
import axios from 'axios';

const App = Vue.createApp({
    components:{
        AppComponent
    }
});
App.use(router)
App.use(store)
App.mount('#app')