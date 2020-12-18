<template>
<div>
    <div class="wrap">
        <header id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button id="primary-nav-button" type="button">Menu</button>
                        <a href="index.html">
                            <div class="logo">
                                <img src="/img/logo.png" alt="Venue Logo">
                            </div>
                        </a>
                        <nav id="primary-nav" class="dropdown cf">
                            <ul class="dropdown menu">
                                <li>
                                    <router-link :to="{name:'store_home'}">Home</router-link>
                                </li>
                                <!--                                    {name:'store/home'}-->
                                <li>
                                    <router-link :to="{name:'store_product'}">Cars</router-link>
                                </li>

                                <li>
                                    <router-link :to="{name:'store_about'}">About</router-link>

                                </li>
                                <li v-if="!isLoggedin">
                                    <Button @click="showLoginModal" type="default">
                                        <Icon type="md-people"/>
                                        Login
                                    </Button>
                                </li>

                                <li v-if="isLoggedin">
                                    <div class="">
                                        <b>Hi,{{user.fullName}}</b>
                                    </div>
                                </li>
                                <li v-if="isLoggedin">
                                    <Button type="default" @click="showCartModal">
                                        <Icon class="nav-link" type="ios-cart-outline"/>
                                        Your cart
                                        <b-badge>{{getCartModalObj.length}}</b-badge>
                                    </Button>
                                </li>


                                <li v-if="!isLoggedin">
                                    <Button type="default" @click="showRegisterModal">
                                        <Icon type="md-person-add" />
                                        Sign up
                                    </Button>
                                </li>

                                <li>
                                    <Button @click="value1 = true" type="default">
                                        <Icon type="md-menu"/>
                                    </Button>
                                </li>
                                <Drawer class="text-center" title="Menu" :closable="false" v-if="isLoggedin" v-model="value1">
                                    <ul class="text-center">
                                        <li v-if="isLoggedin && user.userType!='User'">
                                            <router-link to="/"><h3>Admin dashboard</h3></router-link>
                                        </li>
                                        <li>
                                            <router-link v-if="isloggedin" to="/store/order"><h3>Order</h3></router-link>
                                        </li>
                                        <li>
                                            <a v-if="isloggedin" class="nav-link" href="/store/logout"><h3>Logout</h3></a>
                                        </li>
                                    </ul>
                                </Drawer>
                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>
    </div>
    <section class="banner banner-secondary" id="top"
             style="background-image: url(/img/banner-image-1-1920x300.jpg);">
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
    <cart-modal :user="user" :shopping_cart_id="shopping_cart_id"></cart-modal>
    <login-modal></login-modal>
    <register-modal></register-modal>


    <main>
<!--       <slot :shopping_cart_id="shopping_cart_id" :isloggedin="isloggedin"  :user="user"/>-->
        <router-view :shopping_cart_id="shopping_cart_id" :isloggedin="isloggedin"  :user="user"></router-view>
    </main>
    <chatlog-modal :user="user"></chatlog-modal>
    <footer class="LayoutDefault__footer">
        &copy; Awesome Company
    </footer>
</div>
</template>

<script>
    import Product from '../store/pages/product'
    import cartModal from "../store/components/cartModal";
    import loginModal from "../store/components/loginModal";
    import registerModal from "../store/components/registerModal";
    import chatlogModal from "../store/components/chatModal";
    import notificationBellIcon  from "../store/components/noitificationBellIcon";

    import {mapGetters} from 'vuex'

    export default {
        props: ['user', 'isloggedin'],
        data() {
            return {
                data:{
                    user_id:null,
                    onlineUsers:[],
                    isLoggedIn:false
                },
                isLoggedin: false,
                value1: false,
                counter:0,
                newOrder:null,
                shopping_cart_id:null

            }
        },
        methods: {
            showRegisterModal() {
                const registerModalObj = {
                    showRegisterModal:true,
                    data:null

                }
                this.$store.commit('setRegisterModalObj', registerModalObj);

            },
            showCartModal() {
                const cartModalObj = {
                    showCartModal: true,
                    data: null,
                    deletingIndex: -1,
                    isDeleted: false

                }
                this.$store.commit('setCartModalObj', cartModalObj);

            },
            showLoginModal() {
                const loginModalObj = {
                    showLoginModal: true,
                    data: this.data,
                }

                //console.log(this.getLoginModalObj);
                this.$store.commit('setLoginModalObj', loginModalObj);
            },
            showChatLogModal(){
                const chatLogModalObj = {
                    showChatLogModal:true,
                    data:null
                }

                //console.log(this.getLoginModalObj);
                this.$store.commit('setChatLogModalObj', chatLogModalObj);
            }

        },
        async created() {


            if (this.isloggedin) {
                this.isLoggedin = this.isloggedin
            }

            this.data.user_id=this.user.id;
            const res=await this.callApi('post','/store/get_shoppingcart',this.data);

            if(res.status===200){
                this.shopping_cart_id=res.data[0].id
            }
            else
            {
                this.swr();
            }
            let pusher = new Pusher('83cd2bbd6854b79aa72e', {
                cluster: 'ap1'
            });


            let channel = pusher.subscribe('new-online-user');
            channel.bind('get-online-user', (data) => {
                // console.log(data)
                // console.log(data.user.user_id)
                // console.log(data.for_user_id)
                // console.log(data.user.name)
                //console.log(data.message.author)


                console.log(data)

            })
        },
        components: {
            Product,
            cartModal,
            loginModal,
            registerModal,
            chatlogModal,
            notificationBellIcon
        },
        mounted() {
            // Echo.private('newOrder')
            //     // .here((users)=>{
            //     //    this.usersInRoom=users
            //     // })
            //     // .joining()
            //     // .leaving()
            //     .listen('NewOrder',(e)=>{
            //         console.log(e)
            //         // this.newOrder=e.order
            //         // this.counter++;
            //         // console.log(this.newOrder)
            //         // console.log(this.counter)
            //     })
        },
        computed: {
            ...mapGetters(['getCartModalObj', 'getLoginModalObj','getLoggedInUserObj'])
        }, watch: {

            getLoggedInUserObj(obj) {
                // if(!this.data.isLoggedIn){
                //     this.data.isLoggedIn=obj.isLoggedIn
                // }
                // if(!this.user){
                //     this.user=obj.user
                // }
            }
        },
    }
</script>
