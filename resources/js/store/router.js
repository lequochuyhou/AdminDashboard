import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import store_product from './pages/product'
import store_product_details from './pages/product-details'

const routes=[
    {
        path: '/store/product',
        component: store_product,
        name: 'store/product'
    },
    {
        path: '/store/product-details',
        component: store_product_details,
        name: 'store/product-details'
    },

]

export  default  new Router({
    mode:'history',
    routes
});


