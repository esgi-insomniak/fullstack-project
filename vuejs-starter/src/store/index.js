import { createStore } from 'vuex'
import { auth } from './auth.module'

const store = createStore({
    modules: {
        // Add your modules here
        auth,
    },
})

export default store