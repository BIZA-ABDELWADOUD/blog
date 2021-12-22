// load bootstrap
require('./bootstrap');
require("admin-lte")

// load vue
window.Vue = require('vue')
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);


// import router file
import router from './router'

// import common file 
import common from './common'
Vue.mixin(common)

// import store file
import store from './store'

// import moment js
var moment = require('moment');
Vue.prototype.moment = moment;
// include components
Vue.component('mainapp',require('./components/mainapp.vue').default)
Vue.component('loginapp',require('./components/Loginapp.vue').default)


// use vue
const app = new Vue({
    el : "#app",
    store,
    router
});
