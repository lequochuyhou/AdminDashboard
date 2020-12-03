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
import UserMainApp from '../MainComponents/userMainApp'
export default [
    {
        path: '/store',
        name: 'store',
        component:UserMainApp,
        redirect: {name: 'store_home'},
        children: [
            {
                path: 'product',
                component: storeProduct,
                name: 'store_product'
            },
            {
                path: 'product-details',
                component: storeProductDetails,
                name: 'store_product_details'
            },
            {
                path: '/home',
                component: storeHome,
                name: 'store_home',
            },
            {
                path: 'about',
                component: storeAbout,
                name: 'store_about',
            },
            {
                path: 'order',
                component: storeOrder,
                name: 'store_order',
            },
        ]
    }
]



