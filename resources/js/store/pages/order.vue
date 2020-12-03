<template>
    <div class="mt-5" style="margin-top: 5px">
        <section class="featured-places">
            <div class="container">
                <div><h3>Order details</h3></div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width:50px;" scope="col">#</th>
                        <th style="width: 80px;">Order ID</th>
                        <th style="width: 120px;" scope="col">Day order</th>
                        <th class="text-center" scope="col">Products</th>
                        <th style="width: 100px;" scope="col">Total price</th>
                        <th style="width: 100px;" scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,i) in orderLists" :key="i" v-if="orderLists.length">
                        <td scope="row">{{i+1}}</td>
                        <td scope="row"><router-link :to="'/store/order-details/'+order.id">{{order.id}}</router-link></td>
                        <td>{{moment(order.created_at).format('DD-MM-YY')}}</td>
                        <td >
                            <Collapse >
                                <Panel name="1">
                                    Show details
                                    <p slot="content">
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
                                    </p>
                                </Panel>
                            </Collapse>
                        </td>
                        <!--                        <td>-->
                        <!--                            <Button @click="getProducts(order)">Click</Button>-->
                        <!--                        </td>-->
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
    import moment from 'moment'

    export default {
        props: ['isloggedin', 'user'],
        data() {
            return {
                // isLoggedin:false
                data: {
                    user_id: null
                },
                orderLists: [],
                productLists: [],
                moment:moment,
                value1: '1',
                // token: '',
                // brands: [],
                // categories: [],
                // dataCart: [],
                //totalPrice:0
            }
        },
        methods: {
            addToCart(product) {
                // console.log(product)

                let check = null;
                let index = -1;
                if (this.dataCart) {
                    // check = this.dataCart.map(e => e.id == product.id);
                    index = this.dataCart.findIndex(function (item, i) {
                        return item.id === product.id;
                    });
                }
                // console.log(check)

                if (index != -1) {
                    let price = 0;
                    let totalPrice = 0;

                    this.dataCart[index].quantity += 1;
                    this.dataCart.forEach(function (item) {
                        price = parseFloat(item.price) * item.quantity;
                        //console.log(price)
                        totalPrice = totalPrice + price;
                        //   console.log(totalPrice)

                    })
                    this.updateTotalPrice(totalPrice);
                    // this.updateCart(this.dataCart)
                } else {
                    let price = 0;
                    let totalPrice = 0;
                    let brandName = this.brands.find(brand => brand.id == product.brand_id).brandName;
                    //let deleteIcon = '<Button><Icon type="ios-trash-outline" :objID="' + product.id + '" /></Button>';
                    let data = {
                        id: product.id,
                        image: product.productImage,
                        productName: product.productName,
                        price: product.price,
                        brand: brandName,
                        quantity: 1
                    }

                    if (this.dataCart == null) {
                        console.log('Hello')
                        this.updateTotalPrice(product.price);
                    }
                    this.dataCart.push(data)


                    this.dataCart.forEach(function (item) {
                        price = parseFloat(item.price) * item.quantity;
                        //console.log(price)
                        totalPrice = totalPrice + price;
                        //   console.log(totalPrice)

                    })
                    this.updateTotalPrice(totalPrice);
                    this.updateCart(this.dataCart)
                }
                //console.log(this.dataCart)
            },
            updateCart(data) {
                this.$store.commit('setDataCartModal', data);
            },
            updateTotalPrice(data) {
                //  console.log(data)
                this.$store.commit('setTotalPrice', data);
            },
            async search() {


                const res = await this.callApi('post', '/store/search_product', this.data);
                if (res.status == 200) {
                    this.productLists = res.data
                } else {
                    this.swr();
                }
            },
            getProducts(order) {

                let data = this.orderLists.find(data => data.id == order.id).products;
                this.productLists = JSON.parse(data);
                // console.log(this.productLists)
                return this.productLists;
            },
            getCustomerInfomation(user_id){

            },

        },
        async created() {
            this.token = window.Laravel.csrfToken;

            this.data.user_id = this.user.id;
            const res = await this.callApi('post', '/store/get_order', this.data);

            if (res.status === 200) {
                this.orderLists = res.data


                // console.log(this.orderLists)

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
