require('./bootstrap');

window.Vue=require('vue');
import router from './router'
import ViewUI from 'view-design'
import 'view-design/dist/styles/iview.css'
import store from './store'
Vue.use(ViewUI);
import common from "./common";
Vue.mixin(common);
import Editor from 'vue-editor-js'
Vue.use(Editor);

Vue.component('mainapp',require('./Components/mainapp').default);
const app=new Vue({
    el:'#app',
    router,
    store
})
