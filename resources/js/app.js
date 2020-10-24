require('./bootstrap');

window.Vue = require('vue');
import router from './router'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css'
import store from './store'

Vue.use(ViewUI);
import common from "./common";

Vue.mixin(common);
import Editor from 'vue-editor-js'

Vue.use(Editor);

Vue.component('mainapp', require('./Components/mainapp').default);
Vue.component('storemainapp', require('./Components/storemainapp').default);

// Vue.component('storemainapp',require('./store/'));
// var AdminComponent = require('./Components/mainapp');
// var StoreComponent = require('./Components/storemainapp');

const app = new Vue({
    el: '#app',
    router,
    store
})


//

// const storeapp=new Vue({
//     el:'#storeapp',
//     router,
//     store
// })
