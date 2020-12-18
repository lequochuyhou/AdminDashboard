import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

//project pages
import home from './Components/pages/home'
import tags from './admin/pages/tags'
//import tags from './Components/pages/tags'
import category from './admin/pages/category'
import usecom from './vuex/usecom'
import adminusers from './admin/pages/adminusers'
import login from './admin/pages/login'
import role from './admin/pages/role'
import assignRole from './admin/pages/assignRole'
import createBlog from './admin/pages/createBlog'
import product from './admin/pages/product'
import brand from './admin/pages/brand'
import supplier from './admin/pages/supplier'
import order  from "./admin/pages/order";
import order_details from "./admin/pages/order-details";
// import storeProduct from './store/pages/product'
// import storeProductDetails from './store/pages/product-details'
// import storeHome from './store/pages/home'
// import  storeAbout from './store/pages/about'
// import  storeOrder from './store/pages/order'
// import UserMainApp from './store/MainComponents/userMainApp'
// import  storeOrderDetails from './store/pages/order-details'
import userRoutes from './store/route'
import adminRoutes from './admin/route'

const baseRoutes=[

    //Project routes
    // {
    //     path:'/',
    //     component:home,
    //     name:'/'
    // },
    // {
    //     path:'/testvuex',
    //     component:usecom,
    // },
    // {
    //     path:'/tags',
    //     component:tags,
    //     name:'tags'
    // }, {
    //     path:'/category',
    //     component:category,
    //     name:'category'
    // },{
    //     path:'/adminusers',
    //     component:adminusers,
    //     name:'adminusers'
    // },{
    //     path:'/login',
    //     component:login,
    //     name:'login'
    // },{
    //     path:'/role',
    //     component:role,
    //     name:'role'
    // },{
    //     path:'/assignrole',
    //     component:assignRole,
    //     name:'assignRole'
    // },
    // {
    //     path:'/createBlog',
    //     component:createBlog,
    //     name:'createBlog'
    // },
    // {
    //     path: '/product',
    //     component: product,
    //     name: 'product'
    // },
    // {
    //     path: '/supplier',
    //     component: supplier,
    //     name: 'supplier'
    // },
    // {
    //     path: '/brand',
    //     component: brand,
    //     name: 'brand'
    // },
    // {
    //     path: '/order',
    //     component: order,
    //     name: 'order'
    // },
    // {
    //     path: '/order-details/:id',
    //     component: order_details,
    //     name: 'order-details'
    // },
    // {
    //     path:'/store',
    //     redirect: {name: 'store_home'},
    //     //name:'store',
    //   //  component:UserMainApp,
    //     children:[
    //         {
    //             path: 'product',
    //             component: storeProduct,
    //              name: 'store_product'
    //         },
    //         {
    //             path: 'product-details',
    //             component: storeProductDetails,
    //             // name: 'store_product_details'
    //         },
    //         {
    //             path: 'home',
    //             component: storeHome,
    //             name: 'store_home',
    //         },
    //         {
    //             path: 'about',
    //             component: storeAbout,
    //             name: 'store_about',
    //         },
    //         {
    //             path: 'order',
    //             component: storeOrder,
    //             name: 'store_order',
    //         },
    //     ]
    //
    // },
    // {
    //     path: '/store',
    //     redirect: {name: 'store_home'},
    //     //component: UserMainApp,
    //     //name: 'store'
    // },
    // {
    //     path: '/store/product',
    //     component: storeProduct,
    //     name: 'store_product'
    // },
    // {
    //     path: '/store/product-details',
    //     component: storeProductDetails,
    //     name: 'store/product-details'
    //  },
    // {
    //     path: '/store/home',
    //     component: storeHome,
    //     name: 'store_home',
    // },
    // {
    //     path: '/store/about',
    //     component: storeAbout,
    //     name: 'store_about',
    // },
    // {
    //     path: '/store/order',
    //     component: storeOrder,
    //     name: 'store/order',
    // },
    // {
    //     path: '/store/order-details/:id',
    //     component: storeOrderDetails,
    //     //name: 'store/order-details',
    // },
    // {
    //     path:'/store',
    //     children:[{
    //         path:'/store/home',
    //         name:'storeHome',
    //         components:storeHome
    //     },{
    //         path:'/store/product',
    //         name:'storeProduct',
    //         components:storeProduct
    //     },
    //     ]
    //
    // },
]

const routes=baseRoutes.concat(userRoutes,adminRoutes)

export  default  new Router({
     mode:'history',
    routes
})


