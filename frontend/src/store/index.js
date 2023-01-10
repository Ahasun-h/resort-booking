import { createStore } from 'vuex'

const store = createStore({

    /**
     * Define variables
     */
    state :{
        token : localStorage.getItem('token') || null,
        user_id : localStorage.getItem('user_id') || null
    },

    /**
     *  Update variable value
     */
    mutations:{
        UPDATE_TOKEN(state,payload){
            state.token = payload
        },

        UPDATE_USER_ID(state,payload){
            state.user_id = payload;
        }
    },

    /**
     * Action to be performed
     */
    actions:{
        setToken(context, payload) {
            context.commit('UPDATE_TOKEN',payload);
            localStorage.setItem('token', payload);
        },

        setUserId(context, payload){
            console.log(payload);
            context.commit('UPDATE_USER_ID',payload);
            localStorage.setItem('user_id', payload);
        },

        removeToken(context) {
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN', null);
        },

        removeUserId(context){
            localStorage.removeItem('user_id');
            context.commit('UPDATE_USER_ID', null);

        }
    },

    /**
     * Get status variable value
     */
    getters:{
        getToken: function (state) {
            return state.token
        },

        getUserId: function (state) {
            return state.user_id
        }
    }

});

export  default store;