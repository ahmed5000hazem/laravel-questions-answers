import axios from 'axios'
import ENV from '../ENV'

export const signUp = function (form) {
    return axios.post(`${ENV.BASE_URL}sign-up`, form)
}

export const login = function (form) {
    return axios.post(`${ENV.BASE_URL}login`, form)
}