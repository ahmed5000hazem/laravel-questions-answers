import axios from "axios"
import ENV from "../ENV"

export default class {
    
    constructor(token) {
        axios.get(`${ENV.BASE_URL}user`)
        .then(response => response.data)
        .then(response => {
            for (const key in response)
                this[key] = response[key]
            
        })
        this.token = token
    }
}