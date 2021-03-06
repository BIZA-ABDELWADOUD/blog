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
import blogs from './components/pages/admin/blogs.vue'
import editblog from './components/pages/admin/editblog.vue'
import blogsList from './components/pages/admin/blogsList.vue'
import notfound from './components/pages/admin/notfound.vue'


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
        path : '/blogs',
        component : blogs,
        name : 'blogs'
    },
    {
        path : '/editblog/:id',
        component : editblog,
        name : 'editblog'
    },
    {
        path : '*',
        component : notfound,
        name : 'notfound'
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
    {
        path : '/blogsList',
        component : blogsList,
        name : 'blogsList'
    },


  


]

export default new Router({
    mode : 'history',
    routes
})