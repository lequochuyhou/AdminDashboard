<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">
                        <Button  to="/order">
                          Back to Order
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
<!--                        <paginate :page-count="20" :page-range="15" :prev-text="'Prev'"-->
<!--                                  :next-text="'Next'"-->
<!--                                  :container-class="'pagination'"-->
<!--                                  :click-handler="clickCallback"-->
<!--                                  :page-class="'page-item'">-->
                            <table class="table table-bordered">

                                <tr>
                                    <th scope="col">#</th>
                                    <!--                                <th>Order ID</th>-->
                                    <th>Customer name</th>
                                    <th scope="col">Day order</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Total price</th>
                                    <th scope="col">Status</th>

                                </tr>


                                <tr v-for="(order,i) in orderLists" :key="i" v-if="orderLists.length">
                                    <td scope="row">{{i+1}}</td>
                                    <!--                                <td scope="row"><router-link :to="'/store/order-details/'+order.id">{{order.id}}</router-link></td>-->
                                    <td class="text-bold"><b>{{getCustomerName(order)}}</b> </td>
                                    <!--                                <td></td>-->
                                    <td>{{moment(order.created_at).format('DD-MM-YYYY')}}</td>
                                    <td >
                                        <table class="table table-bordered">

                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product image</th>
                                                <th scope="col">Product name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Quantity</th>
                                            </tr>

                                            <tr v-for="(product,x) in getProducts(order)" :key="x">
                                                <td>{{x+1}}</td>
                                                <td class="table_image"><img :src="`${product.productImage}`"/></td>
                                                <td>{{product.productName}}</td>
                                                <td>{{product.price}}</td>
                                                <td>{{product.brand}}</td>
                                                <td>{{product.quantity}}</td>
                                            </tr>


                                        </table>

                                    </td>
                                    <td>{{order.totalPrice}}</td>
                                    <td>{{order.status}}</td>
                                </tr>


                            </table>
<!--                        </paginate>-->
                        <Page :total="100"/>

                    </div>

                </div>


            </div>
        </div>
    </div>
</template>

<script>

    import {mapGetters} from 'vuex'
    import moment from 'moment'

    export default {
        //  props: ['isloggedin', 'user'],
        data() {
            return {
                data: {
                   order_id:null
                },
                orderLists: [],
                userLists:[],
                productLists: [],
                moment:moment
            }
        },
        methods: {
            getProducts(order) {
                let data = this.orderLists.find(data => data.id == order.id).products;
                this.productLists = JSON.parse(data);
                // console.log(this.productLists)
                return this.productLists;
            },
            getCustomerName(order){
                let fullName=this.userLists.find(user=>user.id==order.user_id).fullName;
                return fullName;
            },
            clickCallback(pageNum){
               // console.log(pageNum)
            }
        },
        async created() {
            this.token = window.Laravel.csrfToken;



            this.data.order_id=this.$route.params.id;;

            const [res,resAllUsers] = await Promise.all([
                this.callApi('post','/app/get_orderdetails',this.data),
                this.callApi('get', '/app/get_allusers')
            ]);
            //const res=await this.callApi('post','/app/get_orderdetails',this.data);


            if (res.status === 200) {
                this.orderLists = res.data

                //console.log(this.orderLists)

            } else {
                this.swr();
            }

            if (resAllUsers.status === 200) {
                this.userLists = resAllUsers.data

                //console.log(this.orderLists)

            } else {
                this.swr();
            }





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
