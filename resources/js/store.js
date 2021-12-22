import Vue from "vue";
import vuex from "vuex";

Vue.use(vuex)

export default new vuex.Store({
    state : {
       user :false,
       Permission : null
    },
    getters : {
        getUserPermission(state) {
             return state.Permission
            
        }
    },
    mutations : {
        setUpdateUser(state,data) {
            state.user = data
        },
        setUpdatePermission(state,data) {
            state.Permission = data
        }
    }
});