import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)
import firstPage from './Components/pages/myFirstVuePage'
import newRoutePage from './Components/pages/newRoutePage'
import hooks from './Components/pages/basic/hooks'
import methods from './Components/pages/basic/methods'

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
import storeProduct from './store/pages/product'
import storeProductDetails from './store/pages/product-details'

const routes=[

    //Project routes
    {
        path:'/',
        component:home,
        name:'/'
    },
    {
        path:'/testvuex',
        component:usecom,
    },
    {
        path:'/tags',
        component:tags,
        name:'tags'
    }, {
        path:'/category',
        component:category,
        name:'category'
    },{
        path:'/adminusers',
        component:adminusers,
        name:'adminusers'
    },{
        path:'/login',
        component:login,
        name:'login'
    },{
        path:'/role',
        component:role,
        name:'role'
    },{
        path:'/assignrole',
        component:assignRole,
        name:'assignRole'
    },
    {
        path:'/createBlog',
        component:createBlog,
        name:'createBlog'
    },
    {
        path: '/product',
        component: product,
        name: 'product'
    },
    {
        path: '/supplier',
        component: supplier,
        name: 'supplier'
    },
    {
        path: '/brand',
        component: brand,
        name: 'brand'
    },
    {
        path: '/store/product',
        component: storeProduct,
        name: 'store/product'
    },
    {
        path: '/store/product-details',
        component: storeProductDetails,
        name: 'store/product-details'
    },




























    //Test routes
    {
        path:'/my-new-vue-route',
        component:firstPage,

    },
    {
        path:'/new-route',
        component:newRoutePage
    },
    // hooks
    {
        path:'/hooks',
        component:hooks
    },{
        path:'/methods',
        component:methods
    },
]

export  default  new Router({
    mode:'history',
    routes
});


