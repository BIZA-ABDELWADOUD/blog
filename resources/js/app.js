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


// import moment js
Vue.use(require('vue-moment'));

// include components
Vue.component('mainapp',require('./components/mainapp.vue').default)

// use vue
const app = new Vue({
    el : "#app",
    router
});
