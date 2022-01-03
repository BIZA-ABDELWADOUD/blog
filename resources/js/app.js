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

// import jsontohtml file
import jsontohtml from './JsonToHtml'
Vue.mixin(jsontohtml)

//import Editor from 'vue-editor-js'

import Editor from 'vue-editor-js/src/index' 
import List from '@editorjs/list';
Vue.use(Editor)

// import store file//
import store from './store'
import Vue from 'vue';

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
