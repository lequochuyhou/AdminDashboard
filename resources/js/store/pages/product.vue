<template>
    <div class="mt-5" style="margin-top: 5px">
        <section class="featured-places">
            <div class="container">
                <!--                <form action="#">-->
                <div class="row">

                    <!--                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 space">-->

                    <div class="col col-lg-2">
                        <Select
                            v-model="data.category_id"
                            placeholder="Select category "
                            style="width: 200px">
                            <Option value="">
                                ------
                            </Option>
                            <Option :value="category.id" v-for="(category,i) in categories" :key="i"
                                    v-if="categories.length">
                                {{category.categoryName}}
                            </Option>
                            <!--                <Option value="Editor">Editor</Option>-->
                        </Select>
                    </div>

                    <div class="col col-lg-2 mr-3 ml-3">
                        <Select
                            v-model="data.brand_id"
                            placeholder="Select brand "
                            style="width: 200px"
                        >
                            <Option value="">
                                ------
                            </Option>
                            <Option :value="brand.id" v-for="(brand,i) in brands" :key="i">
                                {{brand.brandName}}
                            </Option>
                            <!--                <Option value="Editor">Editor</Option>-->
                        </Select>
                    </div>


                    <!--                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 space text-center blue-button">-->
                    <div class="col col-lg-2">
                        <Button type="primary" @click="search">Search</Button>
                    </div>
                </div>
                <!--                </form>-->
            </div>
        </section>

        <section class="featured-places mt-3" style="margin-top: 5px">
            <div class="container">
                <div class="row">

                    <div class="col-md-4 col-sm-6 col-xs-12" v-for="(product,i) in productLists" :key="i"
                         v-if="productLists.length">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <!--                                <img src="/img/product-6-720x480.jpg" alt="">-->
                                    <img  style="height: 200px;width: 360px;" :src="`${product.productImage}`"/>
                                </div>
                                <div class="overlay-content">
                                    <strong>
                                        <Icon type="ios-speedometer"/>
                                        130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>
                                        <Icon type="ios-cube"/>
                                        1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>
                                        <Icon type="ios-cog"/>
                                        Manual</strong>
                                    <Button v-if="isloggedin" type="text" ghost @click="addToCart(product)">
                                        <Icon type="md-cart"/>
                                    </Button>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>{{product.productName}}</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><strong>{{product.price}}</strong> $</span></p>
                                <!--                                <div class="text-button">-->
                                <!--                                     <p>Add to cart</p>-->
                                <!--                                </div>-->
                                <div class="text-button">
                                    <!--                                    <a href="car-details.html">View More</a>-->
                                    <router-link :to="'/store/product_details'">View more details</router-link>
                                    <!--                                    <router-link :to="'/store/product_details'">-->
                                    <!--                                        View more details-->
                                    <!--                                    </router-link>-->
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </div>
</template>

<script>

    import cartModal from "../components/cartModal";
    import brand from "../../admin/pages/brand";
    import {mapGetters} from 'vuex'

    export default {
        props: ['isloggedin','shopping_cart_id'],
        data() {
            return {
                // isLoggedin:false
                data: {
                    brand_id: null,
                    category_id: null,
                    dataCart:[]
                },
                productLists: [],
                token: '',
                brands: [],
                categories: [],
                dataCart: [],
                cart_id:this.shopping_cart_id
                //totalPrice:0
            }
        },
        methods: {
          async  addToCart(product) {
                // console.log(product)
               //  console.log(this.data.dataCart)
                let check = null;
                let index = -1;
                if (this.data.dataCart!=null) {
                    // check = this.dataCart.map(e => e.id == product.id);
                    index = this.data.dataCart.findIndex(item=> {
                        return item.id === product.id;
                    });
                }

                //console.log(index)
                // console.log(check)

                if (index != -1) {
                    let price = 0;
                    let totalPrice = 0;

                    this.data.dataCart[index].quantity += 1;
                    const data={
                        shopping_cart_id:this.cart_id,
                        product_id:this.data.dataCart[index].id,
                        quantity:this.data.dataCart[index].quantity

                    }

                   // console.log(data)
                   this.updateCartItemQuantity(data);

                    this.data.dataCart.forEach(function (item) {
                        price = parseFloat(item.price) * item.quantity;
                        //console.log(price)
                        totalPrice = totalPrice + price;
                        //   console.log(totalPrice)

                    })
                    this.updateTotalPrice(totalPrice);

                    // this.updateCart(this.dataCart)
                } else {
                  //  console.log(this.shopping_cart_id)

                    let price = 0;
                    let totalPrice = 0;
                    let brandName = this.brands.find(brand => brand.id == product.brand_id).brandName;
                    const data = {
                        id: product.id,
                        quantity: 1,
                        shopping_cart_id:this.cart_id,
                        productImage: product.productImage,
                        productName: product.productName,
                        price: product.price,
                        brand: brandName

                    }


                    if (this.data.dataCart== null) {
                      //  console.log('Hello')
                        this.updateTotalPrice(product.price);
                    }
                    this.data.dataCart.push(data)


                    this.data.dataCart.forEach(function (item) {
                        price = parseFloat(item.price) * item.quantity;
                        //console.log(price)
                        totalPrice = totalPrice + price;
                        //   console.log(totalPrice)

                    })
                    this.updateTotalPrice(totalPrice);
                    this.updateCart(this.data.dataCart)

                    this.addCartItem(data)

                }
                // //console.log(this.dataCart)
            },
            updateCart(data) {
                this.$store.commit('setDataCartModal', data);
            },
            updateTotalPrice(data) {
                //  console.log(data)
                this.$store.commit('setTotalPrice', data);
            },
            async search() {
                const res = await this.callApi('post', '/api/search_product', this.data);
                if (res.status == 200) {
                    this.productLists = res.data
                } else {
                    this.swr();
                }
            },
            async addCartItem(data){
                const res=await  this.callApi('post','/api/add_cartitem',data);
                if(res.status===201){
                    this.s('Product added');

                }
                else
                {
                    //console.log(data)
                    this.swr();
                }
            },
            async updateCartItemQuantity(data){
                const res=await  this.callApi('post','/api/update_cartitem_quantity',data);
                if(res.status===200){
                    this.s('Quantity updated');

                }
                else
                {
                    //console.log(data)
                    this.swr();
                }
            }

        },
        async created() {
            this.token = window.Laravel.csrfToken;

            const [res, resCat, resBrand] = await Promise.all([
                this.callApi('get', '/api/product'),
                this.callApi('get', '/api/category'),
                this.callApi('get', '/api/brand'),
            ])

            if (res.status == 200) {
                //console.log('Hello')

                //console.log(res.data)

                this.productLists = res.data
               // sessionStorage.setItem("products", res.data);

            } else {
                this.swr();
            }

            if (resCat.status == 200) {
                //console.log('Hello')

                this.categories = resCat.data
               // sessionStorage.setItem("categories", resCat.data);

            } else {
                this.swr();
            }
            if (resBrand.status == 200) {
                //console.log('Hello')

                this.brands = resBrand.data
               // sessionStorage.setItem("brands", resBrand.data);

                // console.log(this.brands)
            } else {
                this.swr();
            }
            // } else {
            //     this.productLists = productSession;
            //     this.brands = brandSession;
            //     this.categories = catSession;
            // }

            if(this.getCartModalObj.data) {
                this.data.dataCart = this.getCartModalObj.data;
            }


            //console.log(this.getCartModalObj.data)
        },
        computed:{
            ...mapGetters(['getCartModalObj'])
        },
        components: {},
        watch: {
            getCartModalObj(obj) {
              //  console.log(obj)
            },
            setDataCartModal(obj) {
            }
        }
    }
</script>
