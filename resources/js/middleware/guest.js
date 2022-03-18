export default function guest ({ next, store }){
    
    if(store.getters.auth){
        return next({
           name: 'dashboard'
        })
    }

    return next()
}