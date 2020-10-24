<template>
    <div class="mt-5" style="margin-top: 5px">
        <section class="featured-places">
            <div class="container">
                <form action="#">
                    <div class="row">

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 space">


                            <Select
                                v-model="data.category_id"
                                placeholder="Select category "
                                style="width: 200px"
                            >
                                <Option :value="category.id" v-for="(category,i) in categories" :key="i"
                                        v-if="categories.length">
                                    {{category.categoryName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>

                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 space">

                            <Select
                                v-model="data.brand_id"
                                placeholder="Select brand "
                                style="width: 200px"
                            >
                                <Option :value="brand.id" v-for="(brand,i) in brands" :key="i">
                                    {{brand.brandName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>


                        <div class="text-center blue-button">

                            <Button type="primary" @click="search">Search</Button>
                        </div>
                    </div>
                </form>
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
                                    <img :src="`${product.productImage}`"/>
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
                                    <Button type="text" ghost  @click="addToCart(product)">
                                        <Icon type="md-cart"/>
                                    </Button>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>{{product.productName}}</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><strong>{{product.price}}</strong>VND</span></p>
                                <!--                                <div class="text-button">-->
                                <!--                                     <p>Add to cart</p>-->
                                <!--                                </div>-->
                                <div class="text-button">
                                    <!--                                    <a href="car-details.html">View More</a>-->
                                    <router-link :to="'store/product_details'">View more details</router-link>
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
        data() {
            return {
                // isLoggedin:false
                data: {
                    brand_id: null,
                    category_id: null
                },
                productLists: [],
                token: '',
                brands: [],
                categories: [],
                dataCart: [],
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

                if (index!=-1) {
                    let price=0;
                    let totalPrice=0;

                     this.dataCart[index].quantity += 1;
                     this.dataCart.forEach(function (item) {
                         price=parseFloat(item.price)*item.quantity;
                         //console.log(price)
                         totalPrice=totalPrice+price;
                      //   console.log(totalPrice)

                     })
                    this.updateTotalPrice(totalPrice);
                    // this.updateCart(this.dataCart)
                } else  {
                    let price=0;
                    let totalPrice=0;
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

                    if(this.dataCart==null) {
                        console.log('Hello')
                        this.updateTotalPrice(product.price);
                    }
                    this.dataCart.push(data)



                    this.dataCart.forEach(function (item) {
                        price=parseFloat(item.price)*item.quantity;
                        //console.log(price)
                        totalPrice=totalPrice+price;
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
            updateTotalPrice(data){
              //  console.log(data)
                this.$store.commit('setTotalPrice',data);
            },
            async search(){


                const res= await  this.callApi('post','/store/search_product',this.data);
                if (res.status == 200) {
                    this.productLists = res.data
                } else {
                    this.swr();
                }
            }
        },
        async created() {
            // this.token = window.Laravel.csrfToken;

            // const res = await this.callApi('get', '/store/get_product');
            const [res, resCat, resBrand] = await Promise.all([
                this.callApi('get', '/store/get_product'),
                this.callApi('get', '/store/get_category'),
                this.callApi('get', '/store/get_brand'),
            ])
            if (res.status == 200) {
                //console.log('Hello')
                this.productLists = res.data
            } else {
                this.swr();
            }

            if (resCat.status == 200) {
                //console.log('Hello')
                this.categories = resCat.data
                console.log(this.categories)
            } else {
                this.swr();
            }
            if (resBrand.status == 200) {
                //console.log('Hello')
                this.brands = resBrand.data
                console.log(this.brands)
            } else {
                this.swr();
            }
        },
        components: {},
        watch: {
            getCartModalObj(obj) {
                console.log(obj);
                // if(obj.isDeleted){
                //     this.categoryLists.splice(obj.deletingIndex,1);
                // }
            },
            setDataCartModal(obj) {
                console.log(obj.cartProduct)
            }
        }
    }
</script>
