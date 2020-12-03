<template>
    <div>
        <Modal v-model="getRegisterModalObj.showRegisterModal" width="400" height="500" :mask-closable="false"
               :closable="true">

            <div slot="header" class="text-center">
                <h2>Sign up</h2>
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
                <br/>
                <div>
                    <Input prefix="md-information-circle" type="text" placeholder="Enter your full name" style="width: 370px"
                           v-model="data.fullName"/>
                </div>
            </div>

            <div slot="footer">
                <Button type="primary" @click="login">
                    Login
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
                    fullName:''
                },
                isLogging: false,
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
            ...mapGetters(['getRegisterModalObj', 'setRegisterModalObj'])
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

                const res = await this.callApi('post', '/store/register', this.data);

                if (res.status === 201) {

                    this.s('Registered successfully');
                    const registerModalObj = {
                        showRegisterModal:false,
                        data:null

                    }
                    this.$store.commit('setRegisterModalObj', registerModalObj)
                    this.data.email='';
                    this.data.password=''
                    this.data.fullName='';
                    // const loginModalObj = {
                    //     showLoginModal: false,
                    //     data: null,
                    //     isLoggedin: true
                    // }

                    //this.$store.commit('setRegisterModalObj', loginModalObj)
                   // window.location = '/store'
                    //this.$store.commit('setUserData', res.data)

                } else {
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
                const registerModalObj = {
                    showRegisterModal:false,
                    data:null

                }
                this.$store.commit('setRegisterModalObj', registerModalObj)
                this.data.email='';
                this.data.password=''
                this.data.fullName='';
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
