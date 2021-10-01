import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import tags from './components/pages/tags.vue'
import categories from './components/pages/categories.vue'
import home from './components/pages/home.vue'
import users from './components/pages/users.vue'
import first from './components/pages/firstVue.vue'
import second from './components/pages/secondVue.vue'
import testing from './components/pages/testing.vue'
import hooks from './components/pages/tuto/hooks.vue'
import methods from './components/pages/tuto/methods.vue'

const routes = [

    {
        path : '/',
        component : home
    },
    {
        path : '/tags',
        component : tags
    },
    {
        path : '/categories',
        component : categories
    },

    {
        path : '/users',
        component : users
    },
    {
        path : '/first',
        component : first
    },

    {
        path : '/second',
        component : second
    },

    {
        path : '/testing',
        component : testing
    },

    //hooks
    {
        path : '/hooks',
        component : hooks
    },

    //methods 
    {
        path : '/methods',
        component : methods
    }
]

export default new Router({
    mode : 'history',
    routes
})