import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

import tags from './components/pages/admin/tags.vue'
import categories from './components/pages/admin/categories.vue'
import home from './components/pages/admin/home.vue'
import users from './components/pages/admin/users.vue'
import login from './components/pages/admin/login.vue'
import role from './components/pages/admin/role.vue'
import roleAssign from './components/pages/admin/roleAssign.vue'




const routes = [

    {
        path : '/',
        component : home,
        name : 'home'
    },
    {
        path : '/tags',
        component : tags,
        name : 'tags'
    },
    {
        path : '/categories',
        component : categories,
        name : 'categories'
    },
    {
        path : '/users',
        component : users,
        name : 'users'
    },
    {
        path : '/login',
        component : login,
        name : 'login'
    },
    {
        path : '/role',
        component : role,
        name : 'role'
    },
    {
        path : '/Assign_Roles',
        component : roleAssign,
        name : 'Assign_Roles'
    },
  
  


]

export default new Router({
    mode : 'history',
    routes
})