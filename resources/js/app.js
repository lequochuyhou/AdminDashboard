require('./bootstrap');

window.Vue = require('vue');

import router from './router'
//import storeRouter from './store/router'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css'
// import 'bootstrap/dist/css/bootstrap.css';
import  'bootstrap-vue/dist/bootstrap-vue.css'
// import  'vuesax/dist/vuesax.css'
import Paginate from 'vuejs-paginate'
// import Vuesax from 'vuesax'
import store from './store'

Vue.use(ViewUI);
import common from "./common";
import {BootstrapVue,IconsPlugin} from 'bootstrap-vue'
import Chat from 'vue-beautiful-chat'
import UserMainApp from './store/MainComponents/userMainApp'
import AdminMainApp from './admin/MainComponents/adminMainApp'


Vue.mixin(common);
import Editor from 'vue-editor-js'

//import Chat from 'vue-quick-chat'

Vue.use(Editor)
Vue.use(Chat)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Paginate)
// Vue.use(Vuesax)
//
 Vue.component('mainapp', require('./Components/mainapp').default);
 Vue.component('storemainapp', require('./Components/storemainapp').default);

// Vue.component('storemainapp',require('./store/'));
// var AdminComponent = require('./Components/mainapp');
// var StoreComponent = require('./Components/storemainapp');

const app = new Vue({
    el: '#app',
    router,
    store,
    // components:{
    //     'usermainapp':UserMainApp,
    //     'adminmainapp':AdminMainApp
    // }
   // storeRouter
})
    // .$mount("#app")


//

// const storeapp=new Vue({
//     el:'#storeapp',
//     router,
//     store
// })
