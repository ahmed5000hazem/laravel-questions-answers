import { createStore } from 'vuex'

// Create a new store instance.
export const store = createStore({
  state(){
    return {
      user: null,
      isAuth: false,
      token: null
    }
  },
  mutations:{
    initUser (state, data) {
      state.user = data
    },
    checkAuth(state){
      if (localStorage.getItem("authToken") != null) {
        state.isAuth = true
      }else {
        state.isAuth = false
      }
    },
    setToken(state, data){
      state.token = data
    }
  },
  getters:{
    auth(state) {
      return state.isAuth
    },
    user(state){
      return state.user
    },
    userToken(state){
      return state.token
    }
  }
})