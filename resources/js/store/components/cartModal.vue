<template>
    <div>
        <Modal v-model="getCartModalObj.showCartModal" width="1000" height="500" :mask-closable="false"
               :closable="true">

            <div slot="header">
                <h2><Icon type="md-cart" size="24"/>Your cart</h2>
            </div>

            <div v-if="cartProduct==null">
                <span class="text-center"><h3>
                    Your cart is empty
                </h3></span>
            </div>
            <div >
                <!--                <Table stripe :columns="columns1" :data="getCartModalObj.data" v-if="getCartModalObj.data"></Table>-->
                <table class="table table-bordered " v-if="cartProduct">
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
                    <tr v-for="(product,i) in cartProduct" :key="i" v-if="cartProduct">
                        <td class="table_image"><img :src="`${product.productImage}`"/></td>
                        <td>{{product.productName}}</td>
                        <td>{{product.price}}</td>
                        <td>
                            <InputNumber :max="99" :min="1" @on-change="onChange(product,product.quantity,i)"
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
                    <h2>Total price:{{data.totalPrice}} $</h2>
                </span>


            </div>
            <div slot="footer">
                <Button type="primary" @click="checkOut">
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
        props:['user','shopping_cart_id'],
        data() {
            return {
                data:{
                    products:[],
                    totalPrice:0,
                    user_id:null,
                    cart_id:null
                },
                totalPrice: 0,
                isShowing: false,
                cartProduct: [],
                cartData:[],
                products:[],
                brands: [],

                // cart_id:this.shopping_cart_id


            }
        },
        computed: {
            ...mapGetters(['getCartModalObj', 'setDataCartModal','getNotificationData','setNotificationData','setNotification','setTotalPrice'])
        },
        methods: {
            async checkOut() {

                let data=JSON.stringify(this.getCartModalObj.data);
                this.data.products=data;
              //  this.data.totalPrice=this.getCartModalObj.totalPrice;
                this.data.user_id=this.user.id



               // console.log(JSON.stringify(this.data))
                const res=await this.callApi('post','/store/create_order',this.data);

                if(res.status===200)
                {
                   const  cartModalObj={
                        showCartModal: false,
                            data: null,
                            deletingIndex: -1,
                            isDeleted: false,
                            totalPrice:0
                    }
                    const notifications=res.data
                    const notificationData=res.data;

                    this.$store.commit('setCartModalObj',cartModalObj);
                    this.$store.commit('setNotification',notifications);
                    this.data.products=null;
                    this.data.totalPrice=0;



                    this.s('Ordered successfully');
                }
                else {
                    if (res.status === 401) {
                        this.i(res.data.msg);
                    } else if (res.status === 422) {
                        for (let i in res.data.errors) {
                            this.e(res.data.errors[i][0])
                        }
                    } else {
                        this.swr();
                    }
                }


            },
            onChange(product,quantity,i) {
                let price = 0;
                let totalPrice = 0;
                //console.log(quantity)
                //this.cartProduct[i].quantity= this.cartProduct[i].quantity;

                //console.log(this.cartProduct[i])



                const dataObj={
                    quantity:this.cartProduct[i].quantity,
                    shopping_cart_id:  this.data.cart_id,
                    product_id:product.id
                }
                this.updateQuantity(dataObj);

                this.data.totalPrice=0
                this.cartProduct.forEach(data=>{
                    totalPrice=data.quantity*data.price
                    this.data.totalPrice=this.data.totalPrice+totalPrice;
                })
                //console.log(this.data.totalPrice)
                // this.getCartModalObj.data[i].quantity = data;
                // this.getCartModalObj.data.forEach(function (item) {
                //     price = parseFloat(item.price) * item.quantity;
                //     //console.log(price)
                //     totalPrice = totalPrice + price;
                // })
                //
                // this.$store.commit('setTotalPrice', totalPrice)

            },
            removeFromCart(product, i) {
                let price = 0;
                let totalPrice = 0;

                this.cartProduct.splice(i,1);
                this.cartProduct.forEach((data)=>{
                    // console.log(data.quantity)
                    // console.log(data.price)
                    totalPrice=data.quantity*data.price
                    this.data.totalPrice=this.data.totalPrice+totalPrice;
                })

                console.log(this.cartProduct)
                const data={
                    shopping_cart_id:  this.data.cart_id,
                    product_id:product.id
                }
                this.removeCartItem(data);


                // let data = this.getCartModalObj.data;
                // data.splice(i, 1);
                // // console.log(data)
                //
                // data.forEach(function (item) {
                //     price = parseFloat(item.price) * item.quantity;
                //     //console.log(price)
                //     totalPrice = totalPrice + price;
                // })
                //
                // this.$store.commit('setTotalPrice', totalPrice)
            },
            closeModal() {
                this.isShowing = false;
                this.$store.commit('setCartModal', false)
            },
            async updateQuantity(data){
                // const obj={
                //      quantity:quantity
                // }
                const res =await this.callApi('post','/api/update_cartitem_quantity',data);

                if(res.status===200){
                    this.s('Updated');
                }
                else
                {
                    this.swr();
                }
            },
            async removeCartItem(data){
                const res =await this.callApi('post','/api/delete_cartitem',data);

                if(res.status===200){
                    this.s('Deleted');
                }
                else
                {
                    this.swr();
                }

            }
        },
        async created(){
            this.data.user_id=this.user.id;
           // const res=await this.callApi('post','/store/get_shoppingcart',this.data);
            const [res, resProduct,resBrand] = await Promise.all([
                this.callApi('post','/api/get_shoppingcart',this.data),
                this.callApi('get', '/api/product'),
                this.callApi('get', '/api/brand'),
            ])

            if(res.status===200){
                this.data.cart_id=res.data[0].id
                const resCartItems=await this.callApi('post','/store/get_cartitems',this.data);

                if(resCartItems.status===200){
                    this.cartData=resCartItems.data;
                    // console.log('hello')
                    //console.log(this.cartData)
                }
                else
                {
                    this.swr();
                }
            }
            else
            {
                this.swr();
            }

            if(resProduct.status===200){
                this.products=resProduct.data;
               // console.log(this.products)
            }
            else
            {
                this.swr();
            }

            if(resBrand.status===200){
                this.brands=resBrand.data;
              //  console.log(this.products)
            }
            else
            {
                this.swr();
            }

            // this.cartProduct
            this.cartData.forEach(data=>{
              //  console.log(data.product_id)
                let product=this.products.find(product=>product.id==data.product_id);
                let brandName = this.brands.find(brand => brand.id == product.brand_id).brandName;
                const item = {
                    id: product.id,
                    quantity: data.quantity,
                    shopping_cart_id:this.data.cart_id,
                    productImage: product.productImage,
                    productName: product.productName,
                    price: product.price,
                    brand: brandName
                }

                this.cartProduct.push(item);
                // console.log(item)
            });

            this.cartProduct.forEach(data=>{
                this.data.totalPrice+=data.quantity*data.price;
            })

            const dataCartModal=this.cartProduct

            this.$store.commit('setDataCartModal',dataCartModal)
//            console.log(this.cartProduct)

        },
        components: {
            cartModalTable
        }
        ,
        watch: {
            getCartModalObj(obj) {
               // console.log(obj)
                if(this.data.totalPrice===0) {
                    this.data.totalPrice = obj.totalPrice
                    // const data={
                    //     totalPrice:0
                    // }
                    // this.$store.commit('setTotalPrice', data);
                }
            },
            getNotificationData(obj){
           //     console.log(obj)
            }
        }
    }
</script>
