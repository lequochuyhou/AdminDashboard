<template>
    <div>
        <div class="wrap">
            <header id="header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <button id="primary-nav-button" type="button">Menu</button>
                            <a href="index.html"><div class="logo">
                                <img src="/img/logo.png" alt="Venue Logo">
                            </div></a>
                            <nav id="primary-nav" class="dropdown cf">
                                <ul class="dropdown menu">
                                    <li><a href="index.html">Home</a></li>

                                    <li >Cars</li>

                                    <li>
                                        <a href="#">About</a>
                                        <ul class="sub-menu">
                                            <li><a href="#">About Us</a></li>
                                            <li><a href="#">Blog</a></li>
                                            <li><a href="#">Team</a></li>
                                            <li><a href="#">Testimonials</a></li>
                                            <li><a href="#">FAQ</a></li>
                                            <li><a href="#">Terms</a></li>
                                        </ul>
                                    </li>

                                    <li><a class="nav-link" href="#">Contact Us</a></li>
                                    <li><Button type="default" @click="showCartModal"><Icon class="nav-link" type="ios-cart-outline" />Your cart</Button></li>
                                    <li v-if="user.userType!='User' && isLoggedin">
                                        <a class="nav-link" href="/">Go to Admin Dashboard</a>
                                    </li>
                                    <li class="ml-5" v-if="isLoggedin">
                                        <div class="">
                                            <b>Hi,{{user.fullName}}</b>
                                        </div>
                                    </li>
                                </ul>
                            </nav><!-- / #primary-nav -->
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <section class="banner banner-secondary" id="top" style="background-image: url(/img/banner-image-1-1920x300.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="banner-caption">
                            <div class="line-dec"></div>
                            <h2>Cars</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <main>
<!--            <router-view/>-->
            <cart-modal></cart-modal>
            <Product />
        </main>
</div>
</template>

<script>
    import  Product from '../store/pages/product'
    import cartModal from "../store/components/cartModal";
    import {mapGetters} from 'vuex'
    export default {
       props:['user'],
        data(){
            return {
                isLoggedin:false,

            }
        },
        methods:{
          showCartModal(){
              const cartModalObj = {
                  showCartModal:true,
                  data:null,
                  deletingIndex:-1,
                  isDeleted:false

              }
              this.$store.commit('setCartModalObj',cartModalObj);

          }
        },
        created() {
            // this.$store.commit('setUpdateUser',this.user);
            // this.$store.commit('setUserPermission',this.permission);
            // console.log(this.user);
            // console.log(this.permission);
        },
        components:{
           Product,
            cartModal
        },
        computed:{
           ...mapGetters(['getCartModalObj'])
        },watch: {
            getCartModalObj(obj){
                console.log(obj);
                // if(obj.isDeleted){
                //     this.categoryLists.splice(obj.deletingIndex,1);
                // }
            }
        },
    }
</script>
