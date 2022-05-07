import axios from 'axios'
import ENV from '../ENV'
import { createStore } from 'vuex'
import router from "../router"
// Create a new store instance.
export const store = createStore({
  state(){
    return {
      user: {},
      isAuth: false
    }
  },
  mutations:{
    initUser (state, data) {
      // console.log(data)
      state.user = data
    },
    checkAuth(state){
      if (localStorage.getItem("authToken") != null) {
        state.isAuth = true
      }else {
        state.isAuth = false
      }
    }
  },
  getters:{
    auth(state) {
      return state.isAuth
    },
    user(state){
      // console.log(state.user + "from getter");
      return state.user
    },
    number(state){
      return state.num  
    }
  },
  actions:{
    getAuthUser({ commit }){
      axios.get(`${ENV.BASE_URL}user`, {
        headers:{
          "Authorization": "Bearer " + localStorage.getItem("authToken")
        }
      }).then(response => response.data)
      .then(response => {
        commit("initUser", response)
      })
      
    },
    logout({commit}){
      axios.post(`${ENV.BASE_URL}logout`, {}, {
        headers:{
          "Authorization": "Bearer " + localStorage.getItem("authToken")
        }
      })
      .then(response => response.data)
      .then(response => {
        if (response != null && !response.context.error) {
          localStorage.removeItem("authToken")
          commit("initUser", null)
          commit("checkAuth")
          router.push("/login")
        } else if (response.status === 401){
          localStorage.removeItem("authToken")
          commit("initUser", null)
          commit("checkAuth")
          router.push("/login")
        }
      })
    }
  }
})