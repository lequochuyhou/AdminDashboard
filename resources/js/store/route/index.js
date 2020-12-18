// import Vue from 'vue'
// import Router from 'vue-router'
//
// Vue.use(Router)
//

import order from "../pages/order";
import storeProduct from '../pages/product'
import storeProductDetails from '../pages/product-details'
import storeHome from '../pages/home'
import storeAbout from '../pages/about'
import storeOrder from '../pages/order'
import storeOrderDetails from '../pages/order-details'
import storeLayout from '../../Layouts/store'
export default [
    // {
        // path: '/store',
        // name: 'store',
        // // component:storeLayout,
        // redirect: {name: 'store_home'},
        // children: [
        //     {
        //         path: '/product',
        //         component: storeProduct,
        //         name: 'store_product'
        //     },
        //     {
        //         path: '/product-details',
        //         component: storeProductDetails,
        //         name: 'store_product_details'
        //     },
        //     {
        //         path: '/store/home',
        //         component: storeHome,
        //         name: 'store_home',
        //     },
        //     {
        //         path: '/about',
        //         component: storeAbout,
        //         name: 'store_about',
        //     },
        //     {
        //         path: '/order',
        //         component: storeOrder,
        //         name: 'store_order',
        //     },
        //}

    {
        path: '/store/',
        redirect: {name: 'store_home'},
        //component: UserMainApp,
        //name: 'store'
    },
    {
        path: '/store/product',
        component: storeProduct,
        name: 'store_product'
    },
    {
        path: '/store/product-details',
        component: storeProductDetails,
        name: 'store/product-details'
     },
    {
        path: '/store/home',
        component: storeHome,
        name: 'store_home',
    },
    {
        path: '/store/about',
        component: storeAbout,
        name: 'store_about',
    },
    {
        path: '/store/order',
        component: storeOrder,
        name: 'store/order',
    },
    {
        path: '/store/order-details/:id',
        component: storeOrderDetails,
        //name: 'store/order-details',
    },

]



