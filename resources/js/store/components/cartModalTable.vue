<template>
    <div>

<!--        <div  v-if="getCartModalObj.showCartModal">-->
<!--        <table class="table table-bordered" >-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th> Product image</th>-->
<!--                <th> Product name</th>-->
<!--                <th> Price</th>-->
<!--                <th> Brand</th>-->
<!--                <th> Action</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr v-for="(product,i) in getCartModalObj.data" :key="i" v-if="getCartModalObj.data">-->
<!--                <td><img src="{{product.productImage}}"/></td>-->
<!--                <td>{{product.productName}}</td>-->
<!--                <td>{{product.price}}</td>-->
<!--                <td>{{product.brand}}</td>-->
<!--                <td>-->
<!--                    <Icon type="ios-trash-outline"/>-->
<!--                </td>-->
<!--            </tr>-->
<!--            </tbody>-->

<!--        </table>-->
<!--        </div>-->
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                totalPrice: 0,
                isShowing: false,
                cartProduct: [],

            }
        },
        computed: {
            ...mapGetters(['getCartModalObj', 'setDataCartModal'])
        },
        methods: {
            calculatePrice() {

            },
            closeModal() {
                this.isShowing = false;
                this.$store.commit('setCartModal', false)
            }
        },
        watch: {
            getCartModalObj(obj) {
                console.log(obj.data);

            }
        }
    }
</script>
