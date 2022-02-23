import vue from 'vue'

import {createRouter, createWebHistory, RouterView, RouterLink } from 'vue-router'
import Home from '../views/Home'
import Login from '../views/Login'
import Profile from '../views/Profile'
import SignUp from '../views/SignUp'

const History = new createWebHistory()



const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/sign-up',
        name: 'SignUp',
        component: SignUp
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile
    },
    {
        path: '/logout'
    }
]



export default new createRouter({
    history: History,
    routes
})