<template>
    <!--    <Page :total="20" />-->
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">

                    <div class="_overflow _table_div">
                        <table class="table table-bordered text-center">

                            <tr>
                                <th style="width:50px;" scope="col">#</th>
                                <th style="width: 80px;">Order ID</th>
                                <th style="width: 150px;">Customer name</th>
                                <th style="width: 120px;" scope="col">Day order</th>
                                <th class="text-center" scope="col">Products</th>
                                <th style="width: 100px;" scope="col">Total price</th>
                                <th style="width: 100px;" scope="col">Status</th>

                            </tr>


                            <tr v-for="(order,i) in orderLists" :key="i" v-if="orderLists.length">
                                <td scope="row">{{i+1}}</td>
                                <td scope="row">
                                    <router-link :to="'/order-details/'+order.id">{{order.id}}</router-link>
                                </td>
                                <td class="text-bold"><b>{{getCustomerName(order)}}</b></td>
                                <td>{{moment(order.created_at).format('DD-MM-YYYY')}}</td>
                                <td class="text-left">

                                    <!--                                    <Collapse v-model="value2" accordion>-->
                                    <!--                                    <Panel name="1">-->
                                    <!--                                     Show products-->
                                    <!--                                        <p slot="content">-->
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
                                    <!--                                    <table class="table table-bordered">-->

                                    <!--                                        <tr>-->
                                    <!--                                            <th scope="col">#</th>-->
                                    <!--                                            <th scope="col">Product image</th>-->
                                    <!--                                            <th scope="col">Product name</th>-->
                                    <!--                                            <th scope="col">Price</th>-->
                                    <!--                                            <th scope="col">Brand</th>-->
                                    <!--                                            <th scope="col">Quantity</th>-->
                                    <!--                                        </tr>-->

                                    <!--                                        <tr v-for="(product,x) in getProducts(order)" :key="x">-->
                                    <!--                                            <td>{{x+1}}</td>-->
                                    <!--                                            <td class="table_image"><img :src="`${product.image}`"/></td>-->
                                    <!--                                            <td>{{product.productName}}</td>-->
                                    <!--                                            <td>{{product.price}}</td>-->
                                    <!--                                            <td>{{product.brand}}</td>-->
                                    <!--                                            <td>{{product.quantity}}</td>-->
                                    <!--                                        </tr>-->


                                    <!--                                    </table>-->

                                </td>
                                <td>{{order.totalPrice}}</td>
                                <td>{{order.status}}</td>
                            </tr>


                        </table>
                        <Page :total="100" :page-size="15"/>
                    </div>

                </div>

                <div>
                    <!--                    <paginate :page-count="20" :page-range="15" :prev-text="'Prev'"-->
                    <!--                              :next-text="'Next'"-->
                    <!--                              :container-class="'pagination'"-->
                    <!--                              :click-handler="clickCallback"-->
                    <!--                              :page-class="'page-item'">-->

                    <!--                    </paginate>-->
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
                // isLoggedin:false
                data: {
                    user_id: null
                },
                orderLists: [],
                userLists: [],
                productLists: [],
                moment: moment,
                value1: '1',
                dataTable: {
                    columns: [
                        {
                            label: 'Name',
                            field: 'name',
                            sort: 'asc'
                        },
                        {
                            label: 'Position',
                            field: 'position',
                            sort: 'asc'
                        },
                        {
                            label: 'Office',
                            field: 'office',
                            sort: 'asc'
                        },
                        {
                            label: 'Age',
                            field: 'age',
                            sort: 'asc'
                        },
                        {
                            label: 'Start date',
                            field: 'date',
                            sort: 'asc'
                        },
                        {
                            label: 'Salary',
                            field: 'salary',
                            sort: 'asc'
                        }
                    ],
                }
                // token: '',
                // brands: [],
                // categories: [],
                // dataCart: [],
                //totalPrice:0
            }
        },
        methods: {
            getProducts(order) {
                let data = this.orderLists.find(data => data.id == order.id).products;
                this.productLists = JSON.parse(data);
                // console.log(this.productLists)
                return this.productLists;
            },
            getCustomerName(order) {
                let fullName = this.userLists.find(user => user.id == order.user_id).fullName;
                return fullName;
            },
            clickCallback(pageNum) {
                console.log(pageNum)
            }
        },
        async created() {
            this.token = window.Laravel.csrfToken;

            // this.data.user_id = this.user.id;
            //const res = await this.callApi('get', 'app/get_order', this.data);
            const [res, resUser] = await Promise.all([
                this.callApi('get', 'app/get_order'),
                this.callApi('get', 'app/get_allusers'),
                // this.callApi('get', '/store/get_brand'),
            ])


            if (res.status === 200) {
                this.orderLists = res.data
                //console.log(this.orderLists)
                // console.log(this.orderLists)

            } else {
                this.swr();
            }


            if (resUser.status === 200) {
                this.userLists = resUser.data

                console.log(this.userLists)

                // console.log(this.orderLists)

            } else {
                this.swr();
            }

            console.log(this.orderLists)
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
