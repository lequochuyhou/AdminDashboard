<template>
    <div class="mt-5" style="margin-top: 5px">
        <section class="featured-places">
            <div class="container">
                <div><h3>Order details</h3></div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>Order ID</th>
                        <!--                        <th>Customer</th>-->
                        <!--                        <th>Image</th>-->
                        <th scope="col">Day order</th>
                        <th scope="col">Products</th>
                        <th scope="col">Total price</th>
                        <th scope="col">Status</th>
<!--                        <th>{{$route.params.id}}</th>-->

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,i) in orderList" :key="i" v-if="orderList.length">
                        <th scope="row">{{i+1}}</th>
                        <th scope="row">{{order.id}}</th>
                        <!--                        <th><img :src="`${orderLists.product.image}`"/></th>-->
                        <td>{{order.created_at}}</td>
                        <td >
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(product,x) in getProducts(order)" :key="x">
                                    <td>{{x+1}}</td>
                                    <td>{{product.productName}}</td>
                                    <td>{{product.price}}</td>
                                    <td>{{product.brand}}</td>
                                    <td>{{product.quantity}}</td>
                                </tr>
                                </tbody>

                            </table>

                        </td>
                        <td>{{order.totalPrice}}</td>
                        <td>{{order.status}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </section>


    </div>
</template>

<script>

    import cartModal from "../components/cartModal";
    import brand from "../../admin/pages/brand";
    import {mapGetters} from 'vuex'

    export default {
        props: ['isloggedin', 'user'],
        data() {
            return {
                // isLoggedin:false
              //  order_id:null,
                data: {
                    order_id:null,
                },
                orderList: [],
                productLists: [],
            }
        },
        methods: {

            getProducts(order) {

                let data = this.orderList.find(data => data.id == order.id).products;
                this.productLists = JSON.parse(data);
                 console.log(this.productLists)
                 return this.productLists;
            },
            getCustomerInfomation(user_id){

            }
        },
        async created() {
            //this.token = window.Laravel.csrfToken;

            // this.data.user_id = this.user.id;
            this.data.order_id=this.$route.params.id;
            const res = await this.callApi('post', '/store/get_orderdetails', this.data);

            if (res.status === 200) {
                this.orderList = res.data
               // console.log('Hello')
               // this.orderList.unshift(res.data)
                // console.log(this.orderLists)

            } else {
                this.swr();
            }

           // // this.order_id=this.$route.query.id;
           //  console.log(this.$route.params)


            // let urlParams=new URLSearchParams(window.location.search);
            // let myParam=urlParams.get('id');
            // console.log(myParam)
            // console.log(this.$route.params.id)

        },
        components: {},
        watch: {
            getCartModalObj(obj) {
                //   console.log(obj);
            },
            setDataCartModal(obj) {
                // console.log(obj.cartProduct)
            }
        }
    }
</script>
