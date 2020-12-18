<template>
    <div>
        <Modal v-model="getLoginModalObj.showLoginModal" width="400" height="500" :mask-closable="false"
               :closable="true">

            <div slot="header" class="text-center">
                <h2>Sign in</h2>
            </div>

            <div class="d-flex justify-content-center">
                <div>
                    <Input prefix="ios-contact" type="email" placeholder="Enter email" style="width: 370px"
                           v-model="data.email"/>
                </div>
                <br/>
                <div>
                    <Input prefix="ios-lock" type="password" placeholder="Enter password" style="width: 370px"
                           v-model="data.password"/>
                </div>

            </div>

            <div slot="footer">
                <Button type="primary" @click="login" :loading="isLoading">
                    Sign in
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
                data: {
                    email: '',
                    password: '',
                    //  fullName:''
                },
                isLogging: false,
                isLoading:false
                // resources: [
                //     {resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/'},
                //     {resourceName: 'Products', read: true, write: false, update: false, delete: false, name: 'product'},
                //     {
                //         resourceName: 'Suppliers',
                //         read: false,
                //         write: false,
                //         update: false,
                //         delete: false,
                //         name: 'supplier'
                //     },
                //     {resourceName: 'Brands', read: false, write: false, update: false, delete: false, name: 'brand'},
                //     {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                //     {
                //         resourceName: 'Category',
                //         read: false,
                //         write: false,
                //         update: false,
                //         delete: false,
                //         name: 'category'
                //     },
                //     {
                //         resourceName: 'Create blogs',
                //         read: false,
                //         write: false,
                //         update: false,
                //         delete: false,
                //         name: 'createBlog'
                //     },
                //     {
                //         resourceName: 'Admin & Users',
                //         read: false,
                //         write: false,
                //         update: false,
                //         delete: false,
                //         name: 'adminusers'
                //     },
                //     {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role'},
                //     {
                //         resourceName: 'Assign Role',
                //         read: false,
                //         write: false,
                //         update: false,
                //         delete: false,
                //         name: 'assignRole'
                //     },
                //
                //
                // ],

            }
        },
        computed: {
            ...mapGetters(['getLoginModalObj', 'setLoginModalObj','setLoggedInUserObj'])
        },
        methods: {
            async login() {
                // let data=JSON.stringify(this.resources);
                // console.log(data)
                if (this.data.email.trim() == "") {
                    return this.e("Email is required");
                }
                if (this.data.password.trim() == "") {
                    return this.e("Password is required");
                }
                if (this.data.password.length < 6) {
                    return this.e("Incorrect login details");
                }
                this.isLogging = true;
                this.isLoading=true


                const res = await this.callApi('post', '/store/login', this.data);

                if (res.status === 200) {

                    const loginModalObj = {
                        showLoginModal: false,
                        data: null
                    }



                    this.$store.commit('setLoginModalObj', loginModalObj)
                    const data={
                        isLoggedIn:true,
                        user:res.data
                    }
                    this.$store.commit('setLoggedInUserObj',data)
                    this.isLoading=false

                    // let pusher = new Pusher('83cd2bbd6854b79aa72e', {
                    //     cluster: 'ap1'
                    // });
                    //
                    //
                    // let channel = pusher.subscribe('new-online-user' + this.data.for_user_id);
                    // channel.bind('get-online-user', (data) => {
                    //    console.log(data)
                    // })
                    window.location = '/store'
                    //this.$store.commit('setUserData', res.data)

                } else {
                    this.isLoading=false
                    // console.log(hello)
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


                this.isLogging = false;
            },
            closeModal() {
                // this.isShowing = false;
                const loginModalObj = {
                    showLoginModal: false,
                }
                this.$store.commit('setLoginModalObj', loginModalObj)
            }
        },
        components: {
            cartModalTable
        }
        ,
        watch: {
            getCartModalObj(obj) {
                //      console.log(obj.data);
            }
        }
    }
</script>
