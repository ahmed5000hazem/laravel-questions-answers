import vue from 'vue'
import {store} from '../store'

import {createRouter, createWebHistory, RouterView, RouterLink } from 'vue-router'
import Home from '../views/Home'
import Login from '../views/Login'
import Profile from '../views/Profile'
import SignUp from '../views/SignUp'


// middleware
import guest from '../middleware/guest'
import auth from '../middleware/auth'

import middlewarePipeline from './middlewarePipeLine';

const History = new createWebHistory()

const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta:{
            middleware:[auth]
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta:{
            middleware:[guest]
        }
    },
    {
        path: '/sign-up',
        name: 'SignUp',
        component: SignUp,
        meta:{
            middleware:[guest]
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta:{
            middleware:[auth]
        }
    }
]



const router = new createRouter({
    history: History,
    routes
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware

    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })
})

export default router