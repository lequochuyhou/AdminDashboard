<template>
    <div>
        <Modal v-model="getCartModalObj.showCartModal" width="1000" height="500" :mask-closable="false"
               :closable="true">

            <div slot="header">
                <h2>Your cart</h2>
            </div>

            <div>
                <!--                <Table stripe :columns="columns1" :data="getCartModalObj.data" v-if="getCartModalObj.data"></Table>-->


                <table class="table table-bordered ">
                    <thead class="text-bold text-center">
                    <tr class="text-center">
                        <th> Product image</th>
                        <th> Product name</th>
                        <th> Price</th>
                        <th>Quantity</th>
                        <th> Brand</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr v-for="(product,i) in getCartModalObj.data" :key="i" v-if="getCartModalObj.data">
                        <td class="table_image"><img :src="`${product.image}`"/></td>
                        <td>{{product.productName}}</td>
                        <td>{{product.price}}</td>
                        <td>
                            <InputNumber :max="99" :min="1" @on-change="onChange(product.quantity,i)"
                                         v-model="product.quantity"></InputNumber>
                        </td>
                        <td>{{product.brand}}</td>
                        <td>
                            <Button type="error" @click="removeFromCart(product,i)">
                                <Icon type="ios-trash-outline"/>
                            </Button>

                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div>
                <span>
                    <h2>Total price:{{getCartModalObj.totalPrice}} VND</h2>
                </span>


            </div>
            <div slot="footer">
                <Button type="primary">
                    Check out
                </Button>
                <Button type="default" @click="closeModal">
                    Close
                </Button>
            </div>

        </Modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import cartModalTable from "./cartModalTable";

    export default {
        data() {
            return {
                totalPrice: 0,
                isShowing: false,
                cartProduct: [],
                columns1: [
                    {
                        title: 'Product image',
                        key: 'image'
                    },
                    {
                        title: 'Product name',
                        key: 'productname'
                    },
                    {
                        title: 'Price',
                        key: 'price'
                    },
                    {
                        title: 'Quantity',
                        key: 'quantity'
                    },
                    {
                        title: 'Brand',
                        key: 'brand'
                    },
                    {
                        title: 'Action',
                        key: 'deleteAction'
                    }

                ],

            }
        },
        computed: {
            ...mapGetters(['getCartModalObj', 'setDataCartModal'])
        },
        methods: {
            calculatePrice() {

            },
            onChange(data, i) {
                let price = 0;
                let totalPrice = 0;
                this.getCartModalObj.data[i].quantity = data;
                this.getCartModalObj.data.forEach(function (item) {
                    price = parseFloat(item.price) * item.quantity;
                    //console.log(price)
                    totalPrice = totalPrice + price;
                })

                this.$store.commit('setTotalPrice', totalPrice)

            },
            removeFromCart(product, i) {
                let price = 0;
                let totalPrice = 0;
                let data = this.getCartModalObj.data;
                data.splice(i, 1);
                // console.log(data)

                data.forEach(function (item) {
                    price = parseFloat(item.price) * item.quantity;
                    //console.log(price)
                    totalPrice = totalPrice + price;
                })

                this.$store.commit('setTotalPrice', totalPrice)
            },
            closeModal() {
                this.isShowing = false;
                this.$store.commit('setCartModal', false)
            }
        },
        components: {
            cartModalTable
        }
        ,
        watch: {
            getCartModalObj(obj) {
                console.log(obj.data);
                // if(obj.isDeleted){
                //     this.categoryLists.splice(obj.deletingIndex,1);
                // }
            }
        }
    }
</script>
