
import login from '../../admin/pages/login'
import role from '../../admin/pages/role'
import assignRole from '../../admin/pages/assignRole'
import createBlog from '../../admin/pages/createBlog'
import product from '../../admin/pages/product'
import brand from '../../admin/pages/brand'
import supplier from '../../admin/pages/supplier'
import order  from "../../admin/pages/order";
import adminusers from '../../admin/pages/adminusers'
import category from '../../admin/pages/category'
import order_details from '../../admin/pages/order-details'
import tags from '../../admin/pages/tags'

export default [
    {
        path:'/',
        // component:home,
        name:'/'
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
        path: '/order',
        component: order,
        name: 'order'
    },
    {
        path: '/order-details/:id',
        component: order_details,
        name: 'order-details'
    },

]



